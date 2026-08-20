@extends('layouts.app')

@section('content')

<div class="mb-4">

    <h2>Dashboard</h2>

    <p class="text-muted">
        Role & Permission Management System
    </p>

</div>


{{-- Main Statistics --}}

<div class="row">

    <div class="col-md-3 mb-4">

        <div class="card border-primary shadow-sm h-100">

            <div class="card-body text-center">

                <i class="fa-solid fa-users fa-2x text-primary mb-2"></i>

                <h6 class="text-muted">
                    Total Users
                </h6>

                <h2>
                    {{ $totalUsers }}
                </h2>

            </div>

        </div>

    </div>


    <div class="col-md-3 mb-4">

        <div class="card border-success shadow-sm h-100">

            <div class="card-body text-center">

                <i class="fa-solid fa-user-shield fa-2x text-success mb-2"></i>

                <h6 class="text-muted">
                    Total Roles
                </h6>

                <h2>
                    {{ $totalRoles }}
                </h2>

            </div>

        </div>

    </div>


    <div class="col-md-3 mb-4">

        <div class="card border-warning shadow-sm h-100">

            <div class="card-body text-center">

                <i class="fa-solid fa-key fa-2x text-warning mb-2"></i>

                <h6 class="text-muted">
                    Permissions
                </h6>

                <h2>
                    {{ $totalPermissions }}
                </h2>

            </div>

        </div>

    </div>


    <div class="col-md-3 mb-4">

        <div class="card border-danger shadow-sm h-100">

            <div class="card-body text-center">

                <i class="fa-solid fa-box fa-2x text-danger mb-2"></i>

                <h6 class="text-muted">
                    Products
                </h6>

                <h2>
                    {{ $totalProducts }}
                </h2>

            </div>

        </div>

    </div>

</div>


{{-- Activity Statistics --}}

<div class="row">

    <div class="col-md-3 mb-4">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                <h6 class="text-muted">
                    Total Activities
                </h6>

                <h3>
                    {{ $totalActivityLogs }}
                </h3>

            </div>

        </div>

    </div>


    <div class="col-md-3 mb-4">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                <h6 class="text-muted">
                    Today's Activities
                </h6>

                <h3>
                    {{ $todayActivities }}
                </h3>

            </div>

        </div>

    </div>


    <div class="col-md-3 mb-4">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                <h6 class="text-muted">
                    This Week
                </h6>

                <h3>
                    {{ $thisWeekActivities }}
                </h3>

            </div>

        </div>

    </div>


    <div class="col-md-3 mb-4">

        <div class="card shadow-sm">

            <div class="card-body text-center">

                <h6 class="text-muted">
                    This Month
                </h6>

                <h3>
                    {{ $thisMonthActivities }}
                </h3>

            </div>

        </div>

    </div>

</div>


<div class="row">

    {{-- Users by Role --}}

    <div class="col-md-6 mb-4">

        <div class="card shadow-sm h-100">

            <div class="card-header">

                <strong>
                    Users by Role
                </strong>

            </div>


            <div class="card-body">

                @forelse($usersByRole as $role)

                <div class="d-flex justify-content-between align-items-center border-bottom py-2">

                    <span>

                        <i class="fa-solid fa-user-shield me-2"></i>

                        {{ $role->name }}

                    </span>

                    <span class="badge bg-primary">

                        {{ $role->users_count }}

                    </span>

                </div>

                @empty

                <p class="text-muted mb-0">
                    No roles found.
                </p>

                @endforelse

            </div>

        </div>

    </div>


    {{-- Activity Statistics --}}

    <div class="col-md-6 mb-4">

        <div class="card shadow-sm h-100">

            <div class="card-header">

                <strong>
                    Activity Statistics
                </strong>

            </div>


            <div class="card-body">

                @forelse($activityStatistics as $activity)

                <div class="d-flex justify-content-between align-items-center border-bottom py-2">

                    <span>
                        {{ $activity->action }}
                    </span>

                    <span class="badge bg-success">

                        {{ $activity->total }}

                    </span>

                </div>

                @empty

                <p class="text-muted mb-0">
                    No activity data available.
                </p>

                @endforelse

            </div>

        </div>

    </div>

</div>


{{-- Recent Activities --}}

<div class="card shadow-sm mb-4">

    <div class="card-header d-flex justify-content-between align-items-center">

        <strong>
            Recent Activities
        </strong>

        <a
            href="{{ route('activity-logs.index') }}"
            class="btn btn-sm btn-primary">
            View All
        </a>

    </div>


    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-bordered mb-0">

                <thead class="table-light">

                    <tr>

                        <th>User</th>

                        <th>Action</th>

                        <th>Module</th>

                        <th>Date</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($recentActivities as $activity)

                    <tr>

                        <td>

                            @if($activity->user)

                            {{ $activity->user->name }}

                            @else

                            <span class="text-muted">
                                Deleted User
                            </span>

                            @endif

                        </td>

                        <td>

                            <span class="badge bg-primary">

                                {{ $activity->action }}

                            </span>

                        </td>

                        <td>
                            {{ $activity->module }}
                        </td>

                        <td>

                            {{ $activity->created_at->format('d-m-Y H:i') }}

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="4" class="text-center">

                            No recent activities found.

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- Current User Information --}}

<div class="card shadow-sm">

    <div class="card-header">

        <strong>
            Logged In User
        </strong>

    </div>


    <div class="card-body">

        <div class="row">

            <div class="col-md-4">

                <strong>Name:</strong>

                <p>
                    {{ Auth::user()->name }}
                </p>

            </div>


            <div class="col-md-4">

                <strong>Email:</strong>

                <p>
                    {{ Auth::user()->email }}
                </p>

            </div>


            <div class="col-md-4">

                <strong>Roles:</strong>

                <p>

                    @forelse(Auth::user()->roles as $role)

                    <span class="badge bg-success me-1">

                        {{ $role->name }}

                    </span>

                    @empty

                    <span class="text-muted">
                        No roles
                    </span>

                    @endforelse

                </p>

            </div>

        </div>

    </div>

</div>

@endsection