<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\ActivityLog;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Basic Statistics
        |--------------------------------------------------------------------------
        */

        $totalUsers = User::count();

        $totalRoles = Role::count();

        $totalProducts = Product::count();

        $totalPermissions = Permission::count();

        $totalActivityLogs = ActivityLog::count();


        /*
        |--------------------------------------------------------------------------
        | Activity Statistics
        |--------------------------------------------------------------------------
        */

        $todayActivities = ActivityLog::whereDate(
            'created_at',
            today()
        )->count();


        $thisWeekActivities = ActivityLog::whereBetween(
            'created_at',
            [
                now()->startOfWeek(),
                now()->endOfWeek()
            ]
        )->count();


        $thisMonthActivities = ActivityLog::whereBetween(
            'created_at',
            [
                now()->startOfMonth(),
                now()->endOfMonth()
            ]
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Users By Role
        |--------------------------------------------------------------------------
        */

        $usersByRole = Role::withCount('users')
            ->orderBy('users_count', 'desc')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Recent Activities
        |--------------------------------------------------------------------------
        */

        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(10)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Activity Type Statistics
        |--------------------------------------------------------------------------
        */

        $activityStatistics = ActivityLog::selectRaw(
            'action, COUNT(*) as total'
        )
            ->groupBy('action')
            ->orderByDesc('total')
            ->get();


        return view('home', compact(
            'totalUsers',
            'totalRoles',
            'totalProducts',
            'totalPermissions',
            'totalActivityLogs',
            'todayActivities',
            'thisWeekActivities',
            'thisMonthActivities',
            'usersByRole',
            'recentActivities',
            'activityStatistics'
        ));
    }
}
