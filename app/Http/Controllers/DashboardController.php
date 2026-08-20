<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\ActivityLog;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DashboardController extends Controller
{
    public function index()
    {
        // Main statistics
        $totalUsers = User::count();
        $totalRoles = Role::count();
        $totalPermissions = Permission::count();
        $totalProducts = Product::count();

        // Activity statistics
        $totalActivities = ActivityLog::count();

        $todayActivities = ActivityLog::whereDate(
            'created_at',
            today()
        )->count();

        $weekActivities = ActivityLog::whereBetween(
            'created_at',
            [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ]
        )->count();

        $monthActivities = ActivityLog::whereMonth(
            'created_at',
            now()->month
        )
            ->whereYear(
                'created_at',
                now()->year
            )
            ->count();

        // Users grouped by role
        $usersByRole = Role::withCount('users')
            ->orderBy('name')
            ->get();

        // Activity grouped by action
        $activityStatistics = ActivityLog::select('action')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('action')
            ->orderByDesc('total')
            ->get();

        // Recent activities
        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard', compact(
            'totalUsers',
            'totalRoles',
            'totalPermissions',
            'totalProducts',
            'totalActivities',
            'todayActivities',
            'weekActivities',
            'monthActivities',
            'usersByRole',
            'activityStatistics',
            'recentActivities'
        ));
    }
}
