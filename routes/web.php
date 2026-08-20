<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ActivityLogController;


Route::get('/', function () {
    return redirect()->route('dashboard');
});


Auth::routes();


Route::get(
    '/home',
    [HomeController::class, 'index']
)->name('home');


Route::group(['middleware' => ['auth']], function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | Role Permission Matrix
    |--------------------------------------------------------------------------
    */

    Route::get(
        'roles/permission-matrix',
        [RoleController::class, 'permissionMatrix']
    )->name('roles.permission-matrix');


    /*
    |--------------------------------------------------------------------------
    | Activity Log Clear
    |--------------------------------------------------------------------------
    */

    Route::post(
        'activity-logs-clear',
        [ActivityLogController::class, 'clear']
    )->name('activity-logs.clear');


    /*
    |--------------------------------------------------------------------------
    | Resources
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'roles',
        RoleController::class
    );

    Route::resource(
        'users',
        UserController::class
    );

    Route::resource(
        'products',
        ProductController::class
    );

    Route::resource(
        'activity-logs',
        ActivityLogController::class
    );
});
