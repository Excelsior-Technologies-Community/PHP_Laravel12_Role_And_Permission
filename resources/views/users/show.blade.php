@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2>User Details</h2>

        <p class="text-muted mb-0">
            View user roles and effective permissions.
        </p>

    </div>

    <div>

        <a
            class="btn btn-primary"
            href="{{ route('users.index') }}">
            <i class="fa-solid fa-arrow-left"></i>
            Back
        </a>

    </div>

</div>


<div class="row">

    {{-- User Information --}}

    <div class="col-md-6 mb-4">

        <div class="card shadow-sm h-100">

            <div class="card-header">

                <strong>
                    User Information
                </strong>

            </div>


            <div class="card-body">

                <div class="mb-3">

                    <strong>Name:</strong>

                    <div class="mt-1">
                        {{ $user->name }}
                    </div>

                </div>


                <div class="mb-3">

                    <strong>Email:</strong>

                    <div class="mt-1">
                        {{ $user->email }}
                    </div>

                </div>


                <div>

                    <strong>Roles:</strong>

                    <div class="mt-2">

                        @forelse($user->roles as $role)

                        <span class="badge bg-success me-1 mb-1">

                            {{ $role->name }}

                        </span>

                        @empty

                        <span class="text-muted">
                            No roles assigned.
                        </span>

                        @endforelse

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Permission Information --}}

    <div class="col-md-6 mb-4">

        <div class="card shadow-sm h-100">

            <div class="card-header">

                <strong>
                    Effective Permissions
                </strong>

            </div>


            <div class="card-body">

                @if($permissions->count())

                <div class="mb-3">

                    <span class="badge bg-primary">

                        {{ $permissions->count() }}

                        Permissions

                    </span>

                </div>


                <div>

                    @foreach($permissions as $permission)

                    <span class="badge bg-info text-dark me-1 mb-2">

                        {{ $permission->name }}

                    </span>

                    @endforeach

                </div>

                @else

                <div class="alert alert-warning mb-0">

                    No permissions assigned through the user's roles.

                </div>

                @endif

            </div>

        </div>

    </div>

</div>


{{-- Permission Table --}}

<div class="card shadow-sm">

    <div class="card-header">

        <strong>
            Permission Details
        </strong>

    </div>


    <div class="card-body">

        @if($permissions->count())

        <div class="table-responsive">

            <table class="table table-bordered">

                <thead class="table-dark">

                    <tr>

                        <th width="100px">
                            No
                        </th>

                        <th>
                            Permission
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($permissions as $permission)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $permission->name }}
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

        @else

        <p class="text-muted mb-0">
            No permissions found.
        </p>

        @endif

    </div>

</div>

@endsection