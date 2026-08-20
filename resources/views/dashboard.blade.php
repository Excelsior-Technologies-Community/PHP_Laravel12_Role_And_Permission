@extends('layouts.app')

@section('content')

<style>
    .dashboard-page {
        background: #f5f7fb;
        min-height: calc(100vh - 70px);
        padding: 30px 0;
    }

    .dashboard-title {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
    }

    .dashboard-subtitle {
        color: #6b7280;
        font-size: 14px;
    }

    .stat-card {
        border: 0;
        border-radius: 18px;
        overflow: hidden;
        transition: all 0.25s ease;
        position: relative;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.10) !important;
    }

    .stat-card .card-body {
        padding: 24px;
    }

    .stat-icon {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 23px;
        margin-bottom: 18px;
    }

    .stat-label {
        color: #6b7280;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .stat-number {
        font-size: 30px;
        font-weight: 750;
        color: #111827;
        margin: 5px 0;
    }

    .stat-link {
        font-size: 13px;
        text-decoration: none;
        font-weight: 600;
    }

    .users-icon {
        background: #e8f1ff;
        color: #2563eb;
    }

    .roles-icon {
        background: #f3e8ff;
        color: #9333ea;
    }

    .permissions-icon {
        background: #dcfce7;
        color: #16a34a;
    }

    .products-icon {
        background: #fff7ed;
        color: #ea580c;
    }

    .activity-icon {
        background: #eef2ff;
        color: #4f46e5;
    }

    .analytics-card {
        border: 0;
        border-radius: 18px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, .05);
    }

    .analytics-card .card-header {
        background: #fff;
        border-bottom: 1px solid #f0f0f0;
        padding: 20px 22px;
        border-radius: 18px 18px 0 0;
    }

    .section-title {
        font-size: 17px;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
    }

    .section-description {
        font-size: 12px;
        color: #9ca3af;
        margin-top: 3px;
    }

    .role-row {
        padding: 13px 0;
        border-bottom: 1px solid #f1f3f5;
    }

    .role-row:last-child {
        border-bottom: 0;
    }

    .role-name {
        font-size: 14px;
        font-weight: 600;
        color: #374151;
    }

    .role-count {
        min-width: 38px;
        border-radius: 20px;
        font-size: 12px;
        padding: 6px 10px;
    }

    .activity-row {
        padding: 13px 0;
        border-bottom: 1px solid #f1f3f5;
    }

    .activity-row:last-child {
        border-bottom: 0;
    }

    .activity-name {
        font-size: 14px;
        font-weight: 600;
        color: #374151;
    }

    .activity-count {
        min-width: 38px;
        border-radius: 20px;
        font-size: 12px;
        padding: 6px 10px;
    }

    .recent-table {
        margin: 0;
    }

    .recent-table thead th {
        background: #f8fafc;
        color: #6b7280;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .4px;
        padding: 15px 18px;
        border: 0;
    }

    .recent-table tbody td {
        padding: 16px 18px;
        vertical-align: middle;
        border-color: #f1f3f5;
        font-size: 13px;
        color: #374151;
    }

    .recent-table tbody tr {
        transition: background .2s ease;
    }

    .recent-table tbody tr:hover {
        background: #f8fafc;
    }

    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #e0e7ff;
        color: #4338ca;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 700;
        margin-right: 9px;
    }

    .action-badge {
        border-radius: 20px;
        padding: 6px 11px;
        font-size: 11px;
        font-weight: 700;
    }

    .module-badge {
        background: #f3f4f6;
        color: #4b5563;
        border-radius: 8px;
        padding: 5px 9px;
        font-size: 11px;
        font-weight: 600;
    }

    .empty-state {
        padding: 45px 20px;
        text-align: center;
        color: #9ca3af;
    }

    .empty-icon {
        font-size: 35px;
        margin-bottom: 10px;
    }

    .quick-action {
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 12px 15px;
        text-decoration: none;
        color: #374151;
        font-size: 13px;
        font-weight: 600;
        transition: all .2s ease;
        background: white;
    }

    .quick-action:hover {
        background: #f8fafc;
        color: #2563eb;
        border-color: #bfdbfe;
        transform: translateY(-2px);
    }

    .date-badge {
        background: #f3f4f6;
        color: #6b7280;
        border-radius: 8px;
        padding: 6px 9px;
        font-size: 11px;
    }

    @media (max-width: 768px) {

        .dashboard-page {
            padding: 20px 0;
        }

        .dashboard-title {
            font-size: 23px;
        }

        .dashboard-header {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 15px;
        }

        .recent-table {
            min-width: 700px;
        }
    }
</style>


<div class="dashboard-page">

    <div class="container-fluid px-4">

        {{-- =========================================================
             HEADER
        ========================================================== --}}

        <div class="d-flex justify-content-between align-items-center
                    dashboard-header mb-4">

            <div>

                <div class="d-flex align-items-center gap-2 mb-1">

                    <span style="font-size:25px;">
                        📊
                    </span>

                    <h1 class="dashboard-title mb-0">
                        Dashboard Analytics
                    </h1>

                </div>

                <p class="dashboard-subtitle mb-0">
                    Monitor users, roles, permissions, products and
                    system activities.
                </p>

            </div>

            <div class="d-flex gap-2">

                <a
                    href="{{ route('activity-logs.index') }}"
                    class="btn btn-light border">

                    📋 Activity Logs

                </a>

                <a
                    href="{{ route('users.index') }}"
                    class="btn btn-primary">

                    + Manage Users

                </a>

            </div>

        </div>


        {{-- =========================================================
             MAIN STATISTICS
        ========================================================== --}}

        <div class="row g-4 mb-4">


            {{-- USERS --}}

            <div class="col-12 col-sm-6 col-xl-3">

                <div class="card stat-card shadow-sm h-100">

                    <div class="card-body">

                        <div class="stat-icon users-icon">
                            👥
                        </div>

                        <div class="stat-label">
                            Total Users
                        </div>

                        <div class="stat-number">
                            {{ $totalUsers }}
                        </div>

                        <a
                            href="{{ route('users.index') }}"
                            class="stat-link text-primary">

                            Manage Users →
                        </a>

                    </div>

                </div>

            </div>


            {{-- ROLES --}}

            <div class="col-12 col-sm-6 col-xl-3">

                <div class="card stat-card shadow-sm h-100">

                    <div class="card-body">

                        <div class="stat-icon roles-icon">
                            🛡️
                        </div>

                        <div class="stat-label">
                            Total Roles
                        </div>

                        <div class="stat-number">
                            {{ $totalRoles }}
                        </div>

                        <a
                            href="{{ route('roles.index') }}"
                            class="stat-link"
                            style="color:#9333ea;">

                            Manage Roles →

                        </a>

                    </div>

                </div>

            </div>


            {{-- PERMISSIONS --}}

            <div class="col-12 col-sm-6 col-xl-3">

                <div class="card stat-card shadow-sm h-100">

                    <div class="card-body">

                        <div class="stat-icon permissions-icon">
                            🔐
                        </div>

                        <div class="stat-label">
                            Permissions
                        </div>

                        <div class="stat-number">
                            {{ $totalPermissions }}
                        </div>

                        <a
                            href="{{ route('roles.permission-matrix') }}"
                            class="stat-link text-success">

                            Permission Matrix →

                        </a>

                    </div>

                </div>

            </div>


            {{-- PRODUCTS --}}

            <div class="col-12 col-sm-6 col-xl-3">

                <div class="card stat-card shadow-sm h-100">

                    <div class="card-body">

                        <div class="stat-icon products-icon">
                            📦
                        </div>

                        <div class="stat-label">
                            Products
                        </div>

                        <div class="stat-number">
                            {{ $totalProducts }}
                        </div>

                        <a
                            href="{{ route('products.index') }}"
                            class="stat-link"
                            style="color:#ea580c;">

                            Manage Products →

                        </a>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
             ACTIVITY STATISTICS
        ========================================================== --}}

        <div class="row g-4 mb-4">


            {{-- TOTAL --}}

            <div class="col-12 col-sm-6 col-xl-3">

                <div class="card stat-card analytics-card h-100">

                    <div class="card-body">

                        <div class="d-flex
                                    justify-content-between
                                    align-items-start">

                            <div>

                                <div class="stat-label">
                                    Total Activities
                                </div>

                                <div class="stat-number">
                                    {{ $totalActivities }}
                                </div>

                            </div>

                            <div class="stat-icon activity-icon mb-0">
                                📈
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- TODAY --}}

            <div class="col-12 col-sm-6 col-xl-3">

                <div class="card stat-card analytics-card h-100">

                    <div class="card-body">

                        <div class="d-flex
                                    justify-content-between
                                    align-items-start">

                            <div>

                                <div class="stat-label">
                                    Today's Activities
                                </div>

                                <div class="stat-number">
                                    {{ $todayActivities }}
                                </div>

                            </div>

                            <div class="stat-icon permissions-icon mb-0">
                                🕐
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- WEEK --}}

            <div class="col-12 col-sm-6 col-xl-3">

                <div class="card stat-card analytics-card h-100">

                    <div class="card-body">

                        <div class="d-flex
                                    justify-content-between
                                    align-items-start">

                            <div>

                                <div class="stat-label">
                                    This Week
                                </div>

                                <div class="stat-number">
                                    {{ $weekActivities }}
                                </div>

                            </div>

                            <div class="stat-icon users-icon mb-0">
                                📅
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- MONTH --}}

            <div class="col-12 col-sm-6 col-xl-3">

                <div class="card stat-card analytics-card h-100">

                    <div class="card-body">

                        <div class="d-flex
                                    justify-content-between
                                    align-items-start">

                            <div>

                                <div class="stat-label">
                                    This Month
                                </div>

                                <div class="stat-number">
                                    {{ $monthActivities }}
                                </div>

                            </div>

                            <div class="stat-icon roles-icon mb-0">
                                📊
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
             ROLE + ACTIVITY ANALYTICS
        ========================================================== --}}

        <div class="row g-4 mb-4">


            {{-- USERS BY ROLE --}}

            <div class="col-lg-6">

                <div class="card analytics-card h-100">

                    <div class="card-header">

                        <h5 class="section-title">
                            Users by Role
                        </h5>

                        <div class="section-description">
                            Distribution of users across system roles
                        </div>

                    </div>

                    <div class="card-body">

                        @forelse($usersByRole as $role)

                        <div class="role-row
                                        d-flex
                                        justify-content-between
                                        align-items-center">

                            <div class="d-flex
                                            align-items-center
                                            gap-2">

                                <span>
                                    🛡️
                                </span>

                                <span class="role-name">
                                    {{ $role->name }}
                                </span>

                            </div>

                            <span
                                class="badge bg-primary role-count">

                                {{ $role->users_count }}

                            </span>

                        </div>

                        @empty

                        <div class="empty-state">

                            <div class="empty-icon">
                                🛡️
                            </div>

                            No roles found.

                        </div>

                        @endforelse

                    </div>

                </div>

            </div>


            {{-- ACTIVITY STATISTICS --}}

            <div class="col-lg-6">

                <div class="card analytics-card h-100">

                    <div class="card-header">

                        <h5 class="section-title">
                            Activity Statistics
                        </h5>

                        <div class="section-description">
                            Overview of actions performed in the system
                        </div>

                    </div>

                    <div class="card-body">

                        @forelse($activityStatistics as $activity)

                        <div class="activity-row
                                        d-flex
                                        justify-content-between
                                        align-items-center">

                            <div class="d-flex
                                            align-items-center
                                            gap-2">

                                <span>
                                    ⚡
                                </span>

                                <span class="activity-name">
                                    {{ $activity->action }}
                                </span>

                            </div>

                            <span
                                class="badge bg-success activity-count">

                                {{ $activity->total }}

                            </span>

                        </div>

                        @empty

                        <div class="empty-state">

                            <div class="empty-icon">
                                📊
                            </div>

                            No activity data available.

                        </div>

                        @endforelse

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
             QUICK ACTIONS
        ========================================================== --}}

        <div class="card analytics-card mb-4">

            <div class="card-body">

                <div class="d-flex
                            justify-content-between
                            align-items-center
                            flex-wrap gap-3">

                    <div>

                        <h5 class="section-title mb-1">
                            Quick Actions
                        </h5>

                        <div class="section-description">
                            Quickly access commonly used management sections.
                        </div>

                    </div>

                    <div class="d-flex flex-wrap gap-2">

                        <a
                            href="{{ route('users.index') }}"
                            class="quick-action">

                            👥 Users

                        </a>

                        <a
                            href="{{ route('roles.index') }}"
                            class="quick-action">

                            🛡️ Roles

                        </a>

                        <a
                            href="{{ route('roles.permission-matrix') }}"
                            class="quick-action">

                            🔐 Permissions

                        </a>

                        <a
                            href="{{ route('products.index') }}"
                            class="quick-action">

                            📦 Products

                        </a>

                        <a
                            href="{{ route('activity-logs.index') }}"
                            class="quick-action">

                            📋 Activity Logs

                        </a>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
             RECENT ACTIVITIES
        ========================================================== --}}

        <div class="card analytics-card">

            <div class="card-header
                        d-flex
                        justify-content-between
                        align-items-center">

                <div>

                    <h5 class="section-title">
                        Recent Activities
                    </h5>

                    <div class="section-description">
                        Latest actions performed by system users
                    </div>

                </div>

                <a
                    href="{{ route('activity-logs.index') }}"
                    class="btn btn-sm btn-outline-primary">

                    View All →

                </a>

            </div>


            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table recent-table">

                        <thead>

                            <tr>

                                <th>
                                    User
                                </th>

                                <th>
                                    Action
                                </th>

                                <th>
                                    Module
                                </th>

                                <th>
                                    Date
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($recentActivities as $activity)

                            <tr>

                                <td>

                                    <div class="d-flex
                                                    align-items-center">

                                        <span class="user-avatar">

                                            {{
                                                    strtoupper(
                                                        substr(
                                                            $activity->user->name ?? 'S',
                                                            0,
                                                            1
                                                        )
                                                    )
                                                }}

                                        </span>

                                        <strong>
                                            {{ $activity->user->name ?? 'System' }}
                                        </strong>

                                    </div>

                                </td>


                                <td>

                                    @php
                                    $action = strtolower($activity->action);

                                    $badgeClass = match($action) {
                                    'created' => 'bg-success',
                                    'updated' => 'bg-primary',
                                    'deleted' => 'bg-danger',
                                    default => 'bg-secondary',
                                    };
                                    @endphp

                                    <span
                                        class="badge {{ $badgeClass }}
                                                   action-badge">

                                        {{ $activity->action }}

                                    </span>

                                </td>


                                <td>

                                    <span class="module-badge">

                                        {{ $activity->module }}

                                    </span>

                                </td>


                                <td>

                                    <span class="date-badge">

                                        {{ $activity->created_at->format('d M Y, H:i') }}

                                    </span>

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="4">

                                    <div class="empty-state">

                                        <div class="empty-icon">
                                            📋
                                        </div>

                                        <div>
                                            No recent activities found.
                                        </div>

                                    </div>

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        {{-- Footer --}}

        <div class="text-center text-muted mt-4"
            style="font-size:12px;">

            Laravel 12 Role & Permission Management System
            • Dashboard Analytics

        </div>

    </div>

</div>

@endsection