@extends('layouts.app')

@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 fw-bold">
            <i class="fa-solid fa-file-shield text-warning me-2"></i> Security Audit Logs & RBAC Audit Trail
        </h5>
        <div>
            <a href="{{ route('rbac.matrix') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
                <i class="fa-solid fa-table-cells me-1"></i> Matrix Studio
            </a>
        </div>
    </div>

    <div class="card-body p-4">
        <!-- FILTERS -->
        <form method="GET" action="{{ route('rbac.audit_logs') }}" class="row g-3 mb-4 align-items-center">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Search actor, action or target..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <select name="target_type" class="form-select">
                    <option value="">All Target Types</option>
                    <option value="role" {{ request('target_type') == 'role' ? 'selected' : '' }}>Role Changes</option>
                    <option value="user" {{ request('target_type') == 'user' ? 'selected' : '' }}>User Changes / Impersonations</option>
                    <option value="matrix" {{ request('target_type') == 'matrix' ? 'selected' : '' }}>Matrix Toggles</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100 font-bold">
                    <i class="fa-solid fa-filter me-1"></i> Filter Logs
                </button>
            </div>
        </form>

        <!-- AUDIT LOGS TABLE -->
        <div class="table-responsive border rounded-3">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark text-uppercase small">
                    <tr>
                        <th>Timestamp</th>
                        <th>Actor (Administrator)</th>
                        <th>Action Performed</th>
                        <th>Target Resource</th>
                        <th>IP Address</th>
                        <th class="text-end">Details</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td class="small text-muted font-monospace">
                                {{ $log->created_at->format('M d, Y - H:i:s') }}
                            </td>
                            <td>
                                <strong class="d-block text-dark">{{ $log->actor_name }}</strong>
                                <span class="small text-muted">ID: #{{ $log->actor_id ?? 'N/A' }}</span>
                            </td>
                            <td>
                                @php
                                    $badgeClass = 'bg-secondary';
                                    if (str_contains($log->action, 'granted') || str_contains($log->action, 'created')) $badgeClass = 'bg-success';
                                    if (str_contains($log->action, 'revoked') || str_contains($log->action, 'deleted')) $badgeClass = 'bg-danger';
                                    if (str_contains($log->action, 'impersonation')) $badgeClass = 'bg-warning text-dark';
                                    if (str_contains($log->action, 'matrix')) $badgeClass = 'bg-primary';
                                @endphp
                                <span class="badge {{ $badgeClass }} font-monospace px-2 py-1">
                                    {{ str_replace('_', ' ', strtoupper($log->action)) }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-bold text-dark">{{ $log->target_name }}</span>
                                <span class="badge bg-light text-dark border ms-1">{{ strtoupper($log->target_type) }}</span>
                            </td>
                            <td class="small font-monospace text-muted">
                                {{ $log->ip_address ?? '127.0.0.1' }}
                            </td>
                            <td class="text-end">
                                <button type="button" class="btn btn-sm btn-outline-info rounded-pill" data-bs-toggle="modal" data-bs-target="#logModal{{ $log->id }}">
                                    <i class="fa-solid fa-code me-1"></i> JSON Payload
                                </button>

                                <!-- MODAL -->
                                <div class="modal fade" id="logModal{{ $log->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg text-start">
                                        <div class="modal-content">
                                            <div class="modal-header bg-dark text-white">
                                                <h6 class="modal-title font-bold">Audit Payload #{{ $log->id }} - {{ $log->action }}</h6>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body bg-light">
                                                <div class="row g-3">
                                                    <div class="col-md-6">
                                                        <h6 class="fw-bold text-danger">Old Values</h6>
                                                        <pre class="bg-white p-3 border rounded text-xs" style="max-height: 250px; overflow-y: auto;">{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <h6 class="fw-bold text-success">New Values</h6>
                                                        <pre class="bg-white p-3 border rounded text-xs" style="max-height: 250px; overflow-y: auto;">{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">No security audit logs recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
