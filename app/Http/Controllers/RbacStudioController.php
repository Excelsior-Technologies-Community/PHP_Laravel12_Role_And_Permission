<?php

namespace App\Http\Controllers;

use App\Models\AccessViolationLog;
use App\Models\RbacAuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RbacStudioController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Feature 1: Dynamic Permission Matrix Studio
    |--------------------------------------------------------------------------
    */
    public function matrixView()
    {
        $roles = Role::with('permissions')->orderBy('name')->get();
        $permissions = Permission::orderBy('name')->get();

        // Group permissions by module prefix (e.g. user-list -> User Module)
        $groupedPermissions = $permissions->groupBy(function ($perm) {
            $parts = explode('-', $perm->name);
            return count($parts) > 1 ? ucfirst($parts[0]) . ' Management' : 'General Permissions';
        });

        return view('roles.matrix_studio', compact('roles', 'permissions', 'groupedPermissions'));
    }

    public function toggleMatrixPermission(Request $request)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permission_id' => 'required|exists:permissions,id',
            'assigned' => 'required|boolean',
        ]);

        $role = Role::findOrFail($validated['role_id']);
        $permission = Permission::findOrFail($validated['permission_id']);

        $oldPermissions = $role->permissions->pluck('name')->toArray();

        if ($validated['assigned']) {
            $role->givePermissionTo($permission);
            $action = "granted_permission";
        } else {
            $role->revokePermissionTo($permission);
            $action = "revoked_permission";
        }

        $role->refresh();
        $newPermissions = $role->permissions->pluck('name')->toArray();

        // Log to RBAC Audit Logs
        RbacAuditLog::create([
            'actor_id' => Auth::id(),
            'actor_name' => Auth::user() ? Auth::user()->name : 'System Admin',
            'target_type' => 'matrix',
            'target_id' => $role->id,
            'target_name' => "Role: {$role->name} | Perm: {$permission->name}",
            'action' => $action,
            'old_values' => ['permissions' => $oldPermissions],
            'new_values' => ['permissions' => $newPermissions],
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ]);

        return response()->json([
            'success' => true,
            'message' => "Permission '{$permission->name}' " . ($validated['assigned'] ? 'assigned to' : 'revoked from') . " role '{$role->name}'.",
        ]);
    }

    public function bulkUpdateMatrix(Request $request)
    {
        $matrix = $request->input('matrix', []);

        foreach ($matrix as $roleId => $permissionIds) {
            $role = Role::find($roleId);
            if ($role) {
                $oldPerms = $role->permissions->pluck('name')->toArray();
                $permissionIds = array_map('intval', (array)$permissionIds);
                $role->syncPermissions($permissionIds);
                $newPerms = $role->permissions->pluck('name')->toArray();

                RbacAuditLog::create([
                    'actor_id' => Auth::id(),
                    'actor_name' => Auth::user() ? Auth::user()->name : 'System Admin',
                    'target_type' => 'role',
                    'target_id' => $role->id,
                    'target_name' => $role->name,
                    'action' => 'matrix_bulk_updated',
                    'old_values' => ['permissions' => $oldPerms],
                    'new_values' => ['permissions' => $newPerms],
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->header('User-Agent'),
                ]);
            }
        }

        return redirect()->route('rbac.matrix')->with('success', '⚡ Permission Matrix updated successfully!');
    }

    /*
    |--------------------------------------------------------------------------
    | Feature 1 (Part 2): User Impersonation Engine
    |--------------------------------------------------------------------------
    */
    public function impersonate(User $user, Request $request)
    {
        if (Auth::id() === $user->id) {
            return back()->with('error', 'You cannot impersonate yourself.');
        }

        $originalAdmin = Auth::user();

        // Store original admin ID in session
        session(['impersonator_id' => $originalAdmin->id]);
        session(['impersonator_name' => $originalAdmin->name]);

        Auth::login($user);

        RbacAuditLog::create([
            'actor_id' => $originalAdmin->id,
            'actor_name' => $originalAdmin->name,
            'target_type' => 'user',
            'target_id' => $user->id,
            'target_name' => $user->name,
            'action' => 'impersonation_started',
            'old_values' => ['admin_email' => $originalAdmin->email],
            'new_values' => ['impersonated_email' => $user->email],
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent'),
        ]);

        return redirect()->route('dashboard')->with('success', "👤 Now impersonating '{$user->name}'. You can test access permissions live.");
    }

    public function leaveImpersonation(Request $request)
    {
        $impersonatorId = session('impersonator_id');

        if (!$impersonatorId) {
            return redirect()->route('dashboard');
        }

        $adminUser = User::find($impersonatorId);

        if ($adminUser) {
            Auth::login($adminUser);
        }

        session()->forget('impersonator_id');
        session()->forget('impersonator_name');

        return redirect()->route('users.index')->with('success', 'Returned to original Administrator account.');
    }

    /*
    |--------------------------------------------------------------------------
    | Feature 2: Security Audit Logs & Access Violation Radar
    |--------------------------------------------------------------------------
    */
    public function auditLogs(Request $request)
    {
        $query = RbacAuditLog::with('actor')->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('actor_name', 'like', "%{$search}%")
                  ->orWhere('target_name', 'like', "%{$search}%")
                  ->orWhere('action', 'like', "%{$search}%");
            });
        }

        if ($request->filled('target_type')) {
            $query->where('target_type', $request->target_type);
        }

        $logs = $query->paginate(15)->withQueryString();

        return view('rbac.audit_logs', compact('logs'));
    }

    public function accessViolations(Request $request)
    {
        $query = AccessViolationLog::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $violations = $query->paginate(15)->withQueryString();

        $totalViolations = AccessViolationLog::count();
        $flaggedCount = AccessViolationLog::where('status', 'flagged')->count();
        $reviewedCount = AccessViolationLog::where('status', 'reviewed')->count();
        $dismissedCount = AccessViolationLog::where('status', 'dismissed')->count();

        return view('rbac.access_violations', compact(
            'violations',
            'totalViolations',
            'flaggedCount',
            'reviewedCount',
            'dismissedCount'
        ));
    }

    public function updateViolationStatus(AccessViolationLog $violation, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:flagged,reviewed,dismissed',
        ]);

        $violation->update(['status' => $validated['status']]);

        return back()->with('success', "Access Violation #{$violation->id} status updated to '{$validated['status']}'.");
    }
}
