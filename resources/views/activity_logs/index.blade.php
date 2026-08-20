@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2>Activity Logs</h2>

        <p class="text-muted mb-0">
            Monitor user, role and product activities.
        </p>
    </div>

    <div>

        <form
            method="POST"
            action="{{ route('activity-logs.clear') }}"
            style="display:inline;"
            onsubmit="return confirm('Are you sure you want to clear all activity logs?');">

            @csrf

            <button type="submit" class="btn btn-danger">
                <i class="fa-solid fa-trash"></i>
                Clear All Logs
            </button>

        </form>

    </div>

</div>


@if(session('success'))

<div class="alert alert-success">
    {{ session('success') }}
</div>

@endif


<div class="table-responsive">

    <table class="table table-bordered table-hover">

        <thead class="table-dark">

            <tr>

                <th>No</th>

                <th>User</th>

                <th>Action</th>

                <th>Module</th>

                <th>Date</th>

                <th width="220px">Actions</th>

            </tr>

        </thead>

        <tbody>

            @forelse($logs as $log)

            <tr>

                <td>
                    {{ ($logs->currentPage() - 1) * $logs->perPage() + $loop->iteration }}
                </td>

                <td>

                    @if($log->user)

                    {{ $log->user->name }}

                    @else

                    <span class="text-muted">
                        Deleted User
                    </span>

                    @endif

                </td>

                <td>
                    <span class="badge bg-primary">
                        {{ $log->action }}
                    </span>
                </td>

                <td>
                    {{ $log->module }}
                </td>

                <td>
                    {{ $log->created_at->format('d-m-Y H:i') }}
                </td>

                <td>

                    <a
                        href="{{ route('activity-logs.show', $log->id) }}"
                        class="btn btn-info btn-sm">
                        <i class="fa-solid fa-eye"></i>
                        View
                    </a>


                    <form
                        method="POST"
                        action="{{ route('activity-logs.destroy', $log->id) }}"
                        style="display:inline;"
                        onsubmit="return confirm('Delete this activity log?');">

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="btn btn-danger btn-sm">
                            <i class="fa-solid fa-trash"></i>
                            Delete
                        </button>

                    </form>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="6" class="text-center py-4">

                    <i class="fa-solid fa-clock-rotate-left fa-2x text-muted"></i>

                    <p class="mt-2 mb-0">
                        No activity logs found.
                    </p>

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>


<div class="d-flex justify-content-center">

    {{ $logs->links('pagination::bootstrap-5') }}

</div>

@endsection