@extends('layouts.app')

@section('content')

<div class="container-fluid py-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h1 class="mb-1">
                Role Permission Matrix
            </h1>

            <p class="text-muted mb-0">
                View permissions assigned to each role.
            </p>
        </div>

        <a
            href="{{ route('roles.index') }}"
            class="btn btn-secondary">
            ← Back to Roles
        </a>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

    <div class="alert alert-success alert-dismissible fade show">

        {{ session('success') }}

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

    </div>

    @endif


    {{-- Matrix --}}
    <div class="card shadow-sm">

        <div class="card-header bg-dark text-white">

            <h5 class="mb-0">
                Permission Matrix
            </h5>

        </div>


        <div class="card-body">

            @if($roles->isEmpty())

            <div class="alert alert-warning mb-0">
                No roles found.
            </div>

            @elseif($permissions->isEmpty())

            <div class="alert alert-warning mb-0">
                No permissions found.
            </div>

            @else

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">

                        <tr>

                            <th style="min-width: 280px;">
                                Permission
                            </th>

                            @foreach($roles as $role)

                            <th
                                class="text-center"
                                style="min-width: 150px;">
                                {{ $role->name }}
                            </th>

                            @endforeach

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($permissions as $permission)

                        <tr>

                            <td>

                                <strong>
                                    {{ $permission->name }}
                                </strong>

                            </td>


                            @foreach($roles as $role)

                            <td class="text-center">

                                @if($role->hasPermissionTo($permission->name))

                                <span class="badge bg-success px-3 py-2">
                                    ✓ Allowed
                                </span>

                                @else

                                <span class="badge bg-secondary px-3 py-2">
                                    ✕ Not Allowed
                                </span>

                                @endif

                            </td>

                            @endforeach

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            @endif

        </div>

    </div>

</div>

@endsection