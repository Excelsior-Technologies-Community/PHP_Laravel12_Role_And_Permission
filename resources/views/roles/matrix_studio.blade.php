@extends('layouts.app')

@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center py-3">
        <h5 class="mb-0 fw-bold">
            <i class="fa-solid fa-table-cells text-warning me-2"></i> Dynamic Checkbox Permission Matrix Studio
        </h5>
        <div>
            <a href="{{ route('roles.index') }}" class="btn btn-outline-light btn-sm rounded-pill px-3">
                <i class="fa-solid fa-list me-1"></i> Role List
            </a>
        </div>
    </div>

    <div class="card-body p-4">
        <div class="row align-items-center mb-4">
            <div class="col-md-7">
                <p class="text-muted mb-0 small">
                    Toggle checkboxes to dynamically assign or revoke permissions for each role. Changes update in real-time or via Bulk Save.
                </p>
            </div>
            <div class="col-md-5 text-end">
                <input type="text" id="matrixFilter" class="form-control form-control-sm border-secondary d-inline-block w-auto" placeholder="🔍 Search permission name...">
            </div>
        </div>

        <form action="{{ route('rbac.matrix.bulk') }}" method="POST">
            @csrf
            <div class="table-responsive border rounded-3">
                <table class="table table-bordered table-hover align-middle mb-0" id="matrixTable">
                    <thead class="table-dark text-center align-middle">
                        <tr>
                            <th style="width: 300px;" class="text-start ps-3">Permission Name / Module</th>
                            @foreach($roles as $role)
                                <th>
                                    <span class="badge bg-primary fs-6 d-block mb-1">{{ $role->name }}</span>
                                    <span class="small text-light font-monospace opacity-75">({{ $role->permissions->count() }} perms)</span>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groupedPermissions as $moduleName => $modulePerms)
                            <tr class="table-secondary">
                                <td colspan="{{ count($roles) + 1 }}" class="fw-bold text-dark ps-3 py-2 bg-light border-bottom">
                                    <i class="fa-solid fa-layer-group text-primary me-2"></i> {{ $moduleName }} ({{ count($modulePerms) }} permissions)
                                </td>
                            </tr>
                            @foreach($modulePerms as $perm)
                                <tr class="perm-row">
                                    <td class="ps-4 fw-semibold text-secondary">
                                        <span class="perm-name">{{ $perm->name }}</span>
                                    </td>
                                    @foreach($roles as $role)
                                        @php
                                            $hasPerm = $role->hasPermissionTo($perm->name);
                                        @endphp
                                        <td class="text-center">
                                            <div class="form-check d-flex justify-content-center">
                                                <input class="form-check-input matrix-checkbox" 
                                                       type="checkbox" 
                                                       name="matrix[{{ $role->id }}][]" 
                                                       value="{{ $perm->id }}"
                                                       data-role-id="{{ $role->id }}"
                                                       data-perm-id="{{ $perm->id }}"
                                                       {{ $hasPerm ? 'checked' : '' }}
                                                       style="width: 22px; height: 22px; cursor: pointer;">
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div id="ajaxToast" class="small fw-bold text-success" style="display: none;">
                    <i class="fa-solid fa-spinner fa-spin me-1"></i> Updating permission matrix...
                </div>
                <button type="submit" class="btn btn-primary btn-lg font-bold px-5 rounded-3 shadow">
                    <i class="fa-solid fa-floppy-disk me-2"></i> Save Permission Matrix
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Quick Live Filter
        const filterInput = document.getElementById("matrixFilter");
        filterInput.addEventListener("keyup", function () {
            const query = this.value.toLowerCase();
            document.querySelectorAll(".perm-row").forEach(row => {
                const name = row.querySelector(".perm-name").innerText.toLowerCase();
                row.style.display = name.includes(query) ? "" : "none";
            });
        });

        // AJAX Toggle Checkbox
        document.querySelectorAll(".matrix-checkbox").forEach(chk => {
            chk.addEventListener("change", function () {
                const roleId = this.dataset.roleId;
                const permId = this.dataset.permId;
                const assigned = this.checked ? 1 : 0;
                const toast = document.getElementById("ajaxToast");

                toast.style.display = "inline-block";
                toast.innerHTML = `<i class="fa-solid fa-spinner fa-spin me-1"></i> Saving permission...`;

                fetch("{{ route('rbac.matrix.toggle') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        role_id: roleId,
                        permission_id: permId,
                        assigned: assigned
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        toast.innerHTML = `<i class="fa-solid fa-circle-check text-success me-1"></i> ${data.message}`;
                        setTimeout(() => { toast.style.display = "none"; }, 3000);
                    }
                })
                .catch(err => {
                    toast.innerHTML = `<i class="fa-solid fa-triangle-exclamation text-danger me-1"></i> Error updating matrix.`;
                });
            });
        });
    });
</script>
@endsection
