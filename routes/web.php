<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\RbacStudioController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Dynamic Permission Matrix Studio & User Impersonation
    |--------------------------------------------------------------------------
    */
    Route::get('rbac/matrix', [RbacStudioController::class, 'matrixView'])->name('rbac.matrix');
    Route::post('rbac/matrix/toggle', [RbacStudioController::class, 'toggleMatrixPermission'])->name('rbac.matrix.toggle');
    Route::post('rbac/matrix/bulk', [RbacStudioController::class, 'bulkUpdateMatrix'])->name('rbac.matrix.bulk');

    Route::post('users/{user}/impersonate', [RbacStudioController::class, 'impersonate'])->name('users.impersonate');
    Route::post('users/leave-impersonation', [RbacStudioController::class, 'leaveImpersonation'])->name('users.leave_impersonation');

    /*
    |--------------------------------------------------------------------------
    | Security Audit Logs & Unauthorized Access Radar
    |--------------------------------------------------------------------------
    */
    Route::get('rbac/audit-logs', [RbacStudioController::class, 'auditLogs'])->name('rbac.audit_logs');
    Route::get('rbac/access-violations', [RbacStudioController::class, 'accessViolations'])->name('rbac.access_violations');
    Route::post('rbac/access-violations/{violation}/status', [RbacStudioController::class, 'updateViolationStatus'])->name('rbac.access_violations.update_status');

    /*
    |--------------------------------------------------------------------------
    | Role Permission Matrix (Legacy Route)
    |--------------------------------------------------------------------------
    */
    Route::get('roles/permission-matrix', [RoleController::class, 'permissionMatrix'])->name('roles.permission-matrix');

    /*
    |--------------------------------------------------------------------------
    | Activity Log Clear
    |--------------------------------------------------------------------------
    */
    Route::post('activity-logs-clear', [ActivityLogController::class, 'clear'])->name('activity-logs.clear');

    /*
    |--------------------------------------------------------------------------
    | Resources
    |--------------------------------------------------------------------------
    */
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
    Route::resource('activity-logs', ActivityLogController::class);
});
