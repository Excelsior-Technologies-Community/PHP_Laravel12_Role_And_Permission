@extends('layouts.app')

@section('content')
<div class="container">

    <div class="row mb-4">

        <div class="col-md-4 mb-3">
            <div class="card border-primary shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Users</h5>
                    <h2>{{ $totalUsers }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card border-success shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Roles</h5>
                    <h2>{{ $totalRoles }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card border-danger shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Products</h5>
                    <h2>{{ $totalProducts }}</h2>
                </div>
            </div>
        </div>

    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            Dashboard
        </div>

        <div class="card-body">

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <h4 class="mb-3">
                Welcome, {{ Auth::user()->name }}
            </h4>

            <p>
                <strong>Email:</strong>
                {{ Auth::user()->email }}
            </p>

            <p>
                <strong>Role:</strong>
                {{ Auth::user()->roles->pluck('name')->implode(', ') }}
            </p>

            <div class="alert alert-info mt-3 mb-0">
                You are successfully logged in to the Role & Permission Management System.
            </div>

        </div>
    </div>

</div>
@endsection