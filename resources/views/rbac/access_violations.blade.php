@extends('layouts.app')

@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 fw-bold">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> Unauthorized Access Violation Radar (403 Radar)
        </h5>
        <div>
            <a href="{{ route('rbac.audit_logs') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
                <i class="fa-solid fa-file-shield me-1"></i> Audit Logs
            </a>
        </div>
    </div>

    <div class="card-body p-4">
        <!-- KPI CARDS -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="p-3 border rounded-3 bg-light text-center shadow-sm">
                    <span class="text-uppercase small font-bold text-muted d-block">Total 403 Violations</span>
                    <span class="fs-2 fw-black text-dark">{{ number_format($totalViolations) }}</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 border border-danger rounded-3 bg-danger-subtle text-center shadow-sm">
                    <span class="text-uppercase small font-bold text-danger d-block">Active Flagged Alerts</span>
                    <span class="fs-2 fw-black text-danger">{{ number_format($flaggedCount) }}</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 border border-warning rounded-3 bg-warning-subtle text-center shadow-sm">
                    <span class="text-uppercase small font-bold text-warning-emphasis d-block">Reviewed Logs</span>
                    <span class="fs-2 fw-black text-warning-emphasis">{{ number_format($reviewedCount) }}</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 border border-secondary rounded-3 bg-secondary-subtle text-center shadow-sm">
                    <span class="text-uppercase small font-bold text-secondary d-block">Dismissed Alerts</span>
                    <span class="fs-2 fw-black text-secondary">{{ number_format($dismissedCount) }}</span>
                </div>
            </div>
        </div>

        <!-- TABLE OF VIOLATIONS -->
        <div class="table-responsive border rounded-3">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark text-uppercase small">
                    <tr>
                        <th>Timestamp</th>
                        <th>User Account</th>
                        <th>Attempted URL & Route</th>
                        <th>Missing Permission</th>
                        <th>IP Address</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($violations as $v)
                        <tr class="{{ $v->status === 'flagged' ? 'table-danger' : '' }}">
                            <td class="small font-monospace text-muted">
                                {{ $v->created_at->format('M d, Y - H:i:s') }}
                            </td>
                            <td>
                                <strong class="d-block text-dark">{{ $v->user ? $v->user->name : 'Guest/Unknown' }}</strong>
                                <span class="small text-muted">{{ $v->user_email ?? 'N/A' }}</span>
                            </td>
                            <td class="small">
                                <strong class="d-block text-break font-monospace text-primary">{{ $v->attempted_url }}</strong>
                                <span class="badge bg-light text-dark border">Route: {{ $v->route_name ?? 'N/A' }}</span>
                            </td>
                            <td>
                                <span class="badge bg-danger px-2 py-1 font-monospace">
                                    {{ $v->required_permission ?: 'Permission Required' }}
                                </span>
                            </td>
                            <td class="small font-monospace text-muted">
                                {{ $v->ip_address ?? '127.0.0.1' }}
                            </td>
                            <td>
                                @if($v->status === 'flagged')
                                    <span class="badge bg-danger text-white">🚨 FLAGGED</span>
                                @elseif($v->status === 'reviewed')
                                    <span class="badge bg-warning text-dark">⚠️ REVIEWED</span>
                                @else
                                    <span class="badge bg-secondary">DISMISSED</span>
                                @endif
                            </td>
                            <td class="text-end">
                                @if($v->status === 'flagged')
                                    <form action="{{ route('rbac.access_violations.update_status', $v->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="status" value="reviewed">
                                        <button type="submit" class="btn btn-sm btn-outline-warning">Review</button>
                                    </form>
                                @endif

                                @if($v->status !== 'dismissed')
                                    <form action="{{ route('rbac.access_violations.update_status', $v->id) }}" method="POST" class="d-inline ms-1">
                                        @csrf
                                        <input type="hidden" name="status" value="dismissed">
                                        <button type="submit" class="btn btn-sm btn-outline-secondary">Dismiss</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">No 403 unauthorized access violations recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $violations->links() }}
        </div>
    </div>
</div>
@endsection
