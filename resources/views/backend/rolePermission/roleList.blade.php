@extends('backend.layout')

@section('title', 'Role Management')

@section('backend_content')
    @push('backend_css')
        <style>
            :root {
                --primary: #4f46e5;
                --primary-light: #eef2ff;
                --danger: #ef4444;
                --danger-light: #fef2f2;
                --dark: #1e1b4b;
                --gray: #6b7280;
                --border: #e5e7eb;
                --bg: #f9fafb;
                --white: #ffffff;
                --shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
                --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            }

            .rp-wrapper {
                padding: 24px;
                background: var(--bg);
                min-height: 100vh;
            }

            .page-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 24px;
            }

            .page-title {
                font-size: 22px;
                font-weight: 700;
                color: var(--dark);
                margin: 0;
            }

            .page-subtitle {
                font-size: 13px;
                color: var(--gray);
                margin: 4px 0 0;
            }

            .btn-primary {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                background: var(--primary);
                color: white;
                border: none;
                padding: 10px 18px;
                border-radius: 8px;
                font-size: 14px;
                font-weight: 600;
                cursor: pointer;
                text-decoration: none;
                transition: 0.2s;
            }

            .btn-primary:hover {
                background: #4338ca;
                color: white;
            }

            .alert {
                padding: 12px 16px;
                border-radius: 8px;
                margin-bottom: 20px;
                font-size: 14px;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            .alert-success {
                background: #ecfdf5;
                color: #065f46;
                border: 1px solid #a7f3d0;
            }

            .alert-danger {
                background: var(--danger-light);
                color: #991b1b;
                border: 1px solid #fecaca;
            }

            .card {
                background: var(--white);
                border-radius: 12px;
                box-shadow: var(--shadow);
                overflow: hidden;
            }

            .table-wrapper {
                overflow-x: auto;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                font-size: 14px;
            }

            thead {
                background: #f8f9ff;
                border-bottom: 2px solid var(--border);
            }

            thead th {
                padding: 12px 16px;
                text-align: left;
                font-size: 12px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                color: var(--gray);
            }

            tbody tr {
                border-bottom: 1px solid var(--border);
                transition: background 0.15s;
            }

            tbody tr:last-child {
                border-bottom: none;
            }

            tbody tr:hover {
                background: #fafaff;
            }

            tbody td {
                padding: 14px 16px;
                color: #374151;
                vertical-align: middle;
            }

            .role-badge {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 4px 10px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 600;
            }

            .role-badge.super_admin {
                background: #ede9fe;
                color: #5b21b6;
            }

            .role-badge.admin {
                background: #dbeafe;
                color: #1e40af;
            }

            .role-badge.manager {
                background: #dcfce7;
                color: #166534;
            }

            .role-badge.wholesale_buyer {
                background: #fef9c3;
                color: #854d0e;
            }

            .role-badge.customer {
                background: #f3f4f6;
                color: #374151;
            }

            .role-badge.default {
                background: var(--primary-light);
                color: var(--primary);
            }

            .perm-tags {
                display: flex;
                flex-wrap: wrap;
                gap: 4px;
            }

            .perm-tag {
                background: var(--primary-light);
                color: var(--primary);
                font-size: 11px;
                padding: 2px 8px;
                border-radius: 4px;
                font-weight: 500;
            }

            .perm-more {
                background: #f3f4f6;
                color: var(--gray);
                font-size: 11px;
                padding: 2px 8px;
                border-radius: 4px;
                font-weight: 500;
            }

            .action-btns {
                display: flex;
                gap: 6px;
            }

            .btn-icon {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 32px;
                height: 32px;
                border-radius: 6px;
                border: none;
                cursor: pointer;
                text-decoration: none;
                font-size: 14px;
                transition: 0.2s;
            }

            .btn-edit {
                background: var(--primary-light);
                color: var(--primary);
            }

            .btn-edit:hover {
                background: #c7d2fe;
                color: var(--primary);
            }

            .btn-delete {
                background: var(--danger-light);
                color: var(--danger);
            }

            .btn-delete:hover {
                background: #fecaca;
                color: var(--danger);
            }

            .empty-state {
                text-align: center;
                padding: 60px 20px;
                color: var(--gray);
            }

            .empty-state i {
                font-size: 48px;
                color: #d1d5db;
                margin-bottom: 12px;
                display: block;
            }

            .modal-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
                align-items: center;
                justify-content: center;
            }

            .modal-overlay.active {
                display: flex;
            }

            .modal {
                background: white;
                border-radius: 12px;
                padding: 28px;
                width: 100%;
                max-width: 400px;
                box-shadow: var(--shadow-md);
                text-align: center;
            }

            .modal-icon {
                font-size: 48px;
                margin-bottom: 12px;
            }

            .modal h3 {
                font-size: 18px;
                font-weight: 700;
                color: var(--dark);
                margin: 0 0 8px;
            }

            .modal p {
                font-size: 14px;
                color: var(--gray);
                margin: 0 0 20px;
            }

            .modal-btns {
                display: flex;
                gap: 10px;
                justify-content: center;
            }

            .btn-cancel {
                padding: 10px 20px;
                border-radius: 8px;
                border: 1px solid var(--border);
                background: white;
                color: var(--gray);
                font-size: 14px;
                font-weight: 600;
                cursor: pointer;
            }

            .btn-confirm-delete {
                padding: 10px 20px;
                border-radius: 8px;
                border: none;
                background: var(--danger);
                color: white;
                font-size: 14px;
                font-weight: 600;
                cursor: pointer;
            }
        </style>
    @endpush
    <div class="rp-wrapper">

        <div class="page-header">
            <div>
                <h1 class="page-title">Role Management</h1>
                <p class="page-subtitle">Manage all roles and their permissions</p>
            </div>
            <a href="{{ route('dashboard.role-permission.role-create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Create New Role
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif

        <div class="card">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Role Name</th>
                            <th>Permissions</th>
                            <th>Users</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                            @if (!($role->name === 'super_admin' && !auth()->user()->hasRole('super_admin')))
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <span class="role-badge {{ $role->name }}">
                                            <i class="fas fa-shield-alt"></i>
                                            {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="perm-tags">
                                            @foreach ($role->permissions->take(3) as $permission)
                                                <span class="perm-tag">{{ $permission->name }}</span>
                                            @endforeach
                                            @if ($role->permissions->count() > 3)
                                                <span class="perm-more">+{{ $role->permissions->count() - 3 }} more</span>
                                            @endif
                                            @if ($role->permissions->count() === 0)
                                                <span class="perm-more">No permissions</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td><strong>{{ $role->users()->count() }}</strong> users</td>
                                    <td>{{ $role->created_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="action-btns">
                                            <a href="{{ route('dashboard.role-permission.role-edit', $role->id) }}"
                                                class="btn-icon btn-edit" title="Edit">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            @if (!in_array($role->name, ['super_admin', 'admin', 'manager', 'customer', 'wholesale_buyer']))
                                                <button class="btn-icon btn-delete" title="Delete"
                                                    onclick="confirmDelete({{ $role->id }}, '{{ $role->name }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <i class="fas fa-shield-alt"></i>
                                        <p>No roles found.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- Delete Modal --}}
    <div class="modal-overlay" id="deleteModal">
        <div class="modal">
            <div class="modal-icon">🗑️</div>
            <h3>Delete Role?</h3>
            <p>Are you sure you want to delete <strong id="roleNameText"></strong>? This cannot be undone.</p>
            <div class="modal-btns">
                <button class="btn-cancel" onclick="closeModal()">Cancel</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-confirm-delete">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>

    @push('backend_js')
        <script>
            function confirmDelete(id, name) {
                document.getElementById('roleNameText').textContent = name;
                document.getElementById('deleteForm').action = `/dashboard/role-permission/role-delete/${id}`;
                document.getElementById('deleteModal').classList.add('active');
            }

            function closeModal() {
                document.getElementById('deleteModal').classList.remove('active');
            }
        </script>
    @endpush

@endsection
