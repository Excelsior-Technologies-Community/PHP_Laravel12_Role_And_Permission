@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h2>Activity Log Details</h2>

        <p class="text-muted mb-0">
            View complete information about this activity.
        </p>

    </div>

    <a
        href="{{ route('activity-logs.index') }}"
        class="btn btn-primary"
    >
        <i class="fa-solid fa-arrow-left"></i>
        Back
    </a>

</div>


<div class="card shadow-sm">

    <div class="card-header">

        <strong>
            Activity Information
        </strong>

    </div>


    <div class="card-body">

        <div class="row mb-3">

            <div class="col-md-4">

                <strong>ID:</strong>

            </div>

            <div class="col-md-8">

                {{ $activityLog->id }}

            </div>

        </div>


        <div class="row mb-3">

            <div class="col-md-4">

                <strong>User:</strong>

            </div>

            <div class="col-md-8">

                @if($activityLog->user)

                    {{ $activityLog->user->name }}

                    <span class="text-muted">
                        ({{ $activityLog->user->email }})
                    </span>

                @else

                    <span class="text-muted">
                        Deleted User
                    </span>

                @endif

            </div>

        </div>


        <div class="row mb-3">

            <div class="col-md-4">

                <strong>Action:</strong>

            </div>

            <div class="col-md-8">

                <span class="badge bg-primary">

                    {{ $activityLog->action }}

                </span>

            </div>

        </div>


        <div class="row mb-3">

            <div class="col-md-4">

                <strong>Module:</strong>

            </div>

            <div class="col-md-8">

                {{ $activityLog->module }}

            </div>

        </div>


        <div class="row mb-3">

            <div class="col-md-4">

                <strong>Created At:</strong>

            </div>

            <div class="col-md-8">

                {{ $activityLog->created_at->format('d-m-Y H:i:s') }}

            </div>

        </div>


        <div class="row">

            <div class="col-md-4">

                <strong>Updated At:</strong>

            </div>

            <div class="col-md-8">

                {{ $activityLog->updated_at->format('d-m-Y H:i:s') }}

            </div>

        </div>

    </div>

</div>

@endsection