@extends('backend.layout')

@push('backend_css')
<style>

    /* ─── Page Header ─────────────────────────────────── */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .page-header h4 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e1b4b;
    }
    .page-header small {
        display: block;
        font-size: 0.78rem;
        color: #9ca3af;
        font-weight: 400;
        margin-top: 2px;
    }

    /* ─── Alert ───────────────────────────────────────── */
    .rp-alert {
        padding: 10px 16px;
        border-radius: 7px;
        margin-bottom: 16px;
        font-size: 0.84rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .rp-alert.success { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
    .rp-alert.danger  { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

    /* ─── Search ──────────────────────────────────────── */
    .search-bar { margin-bottom: 14px; }
    .search-bar input {
        width: 100%;
        max-width: 300px;
        padding: 8px 13px;
        border: 1px solid #e5e7eb;
        border-radius: 7px;
        font-size: 0.84rem;
        outline: none;
        color: #374151;
    }
    .search-bar input:focus { border-color: #4f7cff; box-shadow: 0 0 0 3px rgba(79,124,255,0.1); }

    /* ─── Table Card ──────────────────────────────────── */
    .table-card {
        background: #fff;
        border-radius: 10px;
        border: 1px solid #e5e7eb;
        overflow-x: auto;
    }

    /* ─── Table ───────────────────────────────────────── */
    .table-card table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.855rem;
    }
    .table-card thead th {
        background: #f9fafb;
        color: #6b7280;
        font-weight: 600;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        padding: 11px 16px;
        text-align: left;
        border-bottom: 1px solid #e5e7eb;
        white-space: nowrap;
    }
    .table-card tbody tr {
        border-bottom: 1px solid #f3f4f6;
        transition: background 0.12s;
    }
    .table-card tbody tr:last-child { border-bottom: none; }
    .table-card tbody tr:hover { background: #fafbff; }
    .table-card tbody td {
        padding: 12px 16px;
        color: #374151;
        vertical-align: middle;
    }

    /* ─── User Cell ───────────────────────────────────── */
    .user-cell { display: flex; align-items: center; gap: 9px; }
    .avatar {
        width: 35px; height: 35px; border-radius: 50%;
        background: #e0e7ff; color: #4f7cff;
        font-weight: 700; font-size: 0.8rem;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; overflow: hidden; text-transform: uppercase;
    }
    .avatar img { width: 100%; height: 100%; object-fit: cover; }
    .user-name  { font-weight: 600; color: #111827; font-size: 0.875rem; line-height: 1.3; }
    .user-email { font-size: 0.75rem; color: #9ca3af; line-height: 1.3; }

    /* ─── Role Badge ──────────────────────────────────── */
    .role-badge {
        display: inline-flex; align-items: center;
        padding: 3px 10px; border-radius: 20px;
        font-size: 0.74rem; font-weight: 600;
        white-space: nowrap;
    }
    .role-badge.super_admin     { background: #ede9fe; color: #5b21b6; }
    .role-badge.admin           { background: #dbeafe; color: #1e40af; }
    .role-badge.manager         { background: #dcfce7; color: #166534; }
    .role-badge.wholesale_buyer { background: #fef9c3; color: #854d0e; }
    .role-badge.customer        { background: #f3f4f6; color: #374151; }
    .role-badge.no-role         { background: #fee2e2; color: #991b1b; }

    /* ─── Wholesale Badge ─────────────────────────────── */
    .ws-active {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 9px; border-radius: 20px;
        font-size: 0.73rem; font-weight: 600;
        background: #fef9c3; color: #92400e;
    }
    .ws-none { color: #d1d5db; font-size: 0.85rem; }

    /* ─── Action Buttons ──────────────────────────────── */
    .actions { display: flex; align-items: center; gap: 5px; flex-wrap: nowrap; }

    /* Icon-only button (assign role, delete) */
    .btn-action {
        width: 30px; height: 30px;
        border-radius: 6px;
        border: 1px solid #e5e7eb;
        background: #fff; color: #9ca3af;
        display: inline-flex; align-items: center; justify-content: center;
        cursor: pointer; text-decoration: none;
        transition: all 0.15s; flex-shrink: 0;
    }
    .btn-action svg { width: 13px; height: 13px; }
    .btn-action.assign:hover { border-color: #4f7cff; color: #4f7cff; background: #eef2ff; }
    .btn-action.delete:hover { border-color: #ef4444; color: #ef4444; background: #fef2f2; }

    /* Text button (wholesale) */
    .btn-ws {
        height: 28px;
        padding: 0 10px;
        border-radius: 6px;
        font-size: 0.74rem; font-weight: 600;
        border: none; cursor: pointer;
        display: inline-flex; align-items: center; gap: 4px;
        white-space: nowrap; flex-shrink: 0; transition: 0.15s;
    }
    .btn-ws.grant  { background: #fef9c3; color: #92400e; }
    .btn-ws.grant:hover  { background: #fde68a; }
    .btn-ws.revoke { background: #fee2e2; color: #991b1b; }
    .btn-ws.revoke:hover { background: #fecaca; }

    /* ─── Empty State ─────────────────────────────────── */
    .empty-cell { text-align: center; padding: 48px 20px; color: #9ca3af; }
    .empty-cell svg { width: 40px; height: 40px; margin-bottom: 10px; color: #d1d5db; }

    /* ─── Table Footer ────────────────────────────────── */
    .table-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 11px 16px;
        border-top: 1px solid #e5e7eb;
        font-size: 0.8rem;
        color: #9ca3af;
        flex-wrap: wrap;
        gap: 8px;
    }

    /* ─── Modal ───────────────────────────────────────── */
    .rp-modal-wrap {
        display: none;
        position: fixed; inset: 0;
        background: rgba(0,0,0,0.4);
        z-index: 1060;
        align-items: center;
        justify-content: center;
        padding: 16px;
    }
    .rp-modal-wrap.open { display: flex; }
    .rp-modal {
        background: #fff;
        border-radius: 10px;
        padding: 26px 24px;
        width: 100%;
        max-width: 380px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
    }
    .rp-modal-head { margin-bottom: 16px; }
    .rp-modal-head h5 {
        margin: 0 0 4px;
        font-size: 1rem; font-weight: 700; color: #1e1b4b;
    }
    .rp-modal-head p {
        margin: 0; font-size: 0.82rem; color: #6b7280;
    }
    .rp-modal label {
        display: block;
        font-size: 0.82rem; font-weight: 600;
        color: #374151; margin-bottom: 6px;
    }
    .rp-modal select {
        width: 100%;
        padding: 9px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 7px;
        font-size: 0.875rem;
        background: #fff;
        box-sizing: border-box;
        margin-bottom: 18px;
        color: #374151;
    }
    .rp-modal select:focus { outline: none; border-color: #4f7cff; box-shadow: 0 0 0 3px rgba(79,124,255,0.1); }
    .rp-modal-btns { display: flex; gap: 8px; }
    .rp-modal-btns .btn-save {
        flex: 1; padding: 9px;
        background: #4f7cff; color: #fff;
        border: none; border-radius: 7px;
        font-size: 0.875rem; font-weight: 600;
        cursor: pointer; transition: 0.15s;
    }
    .rp-modal-btns .btn-save:hover { background: #3a65e8; }
    .rp-modal-btns .btn-cancel {
        flex: 1; padding: 9px;
        background: #fff; color: #6b7280;
        border: 1px solid #e5e7eb; border-radius: 7px;
        font-size: 0.875rem; font-weight: 600;
        cursor: pointer; transition: 0.15s;
    }
    .rp-modal-btns .btn-cancel:hover { background: #f9fafb; }

</style>
@endpush

@section('backend_content')
<div class="container-fluid py-4">

    {{-- ── Page Header ──────────────────────────────── --}}
    <div class="page-header">
        <div>
            <h4>
                Users & Permissions
                <small>Assign roles and manage wholesale access</small>
            </h4>
        </div>
    </div>

    {{-- ── Alerts ───────────────────────────────────── --}}
    
    {{-- ── Search ───────────────────────────────────── --}}
    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="  Search by name or email…">
    </div>

    {{-- ── Table ────────────────────────────────────── --}}
    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>User</th>
                    <th>Role</th>
                    <th>Wholesale</th>
                    <th>Joined</th>
                    <th style="width:160px;">Actions</th>
                </tr>
            </thead>
            <tbody id="userTable">

                @forelse($users as $user)
                <tr>

                    {{-- # --}}
                    <td>{{ $loop->iteration }}</td>

                    {{-- User --}}
                    <td>
                        <div class="user-cell">
                            <div class="avatar">
                                @if($user->user_image)
                                    <img src="{{ asset( $user->user_image) }}" alt="">
                                @else
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                @endif
                            </div>
                            <div>
                                <div class="user-name">{{ $user->name }}</div>
                                <div class="user-email">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>

                    {{-- Role --}}
                    <td>
                        @if($user->roles->count())
                            @foreach($user->roles as $role)
                                <span class="role-badge {{ $role->name }}">
                                    {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                </span>
                            @endforeach
                        @else
                            <span class="role-badge no-role">No Role</span>
                        @endif
                    </td>

                    {{-- Wholesale --}}
                    <td>
                        @if($user->hasWholesaleAccess())
                            <span class="ws-active">⭐ Active</span>
                        @else
                            <span class="ws-none">—</span>
                        @endif
                    </td>

                    {{-- Joined --}}
                    <td>{{ $user->created_at->format('d M Y') }}</td>

                    {{-- Actions --}}
                    <td>
                        <div class="actions">

                            {{-- Assign Role (Super Admin & Admin only) --}}
                            @hasanyrole('super_admin|admin')
                                @if(!($user->hasRole('super_admin') && !auth()->user()->hasRole('super_admin')))
                                    <button
                                        class="btn-action assign"
                                        title="Assign Role"
                                        onclick="openRoleModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ $user->roles->first()?->name }}')">
                                        {{-- People icon --}}
                                        <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                            <circle cx="9" cy="7" r="4"/>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                                        </svg>
                                    </button>
                                @endif
                            @endhasanyrole

                            {{-- Grant / Revoke Wholesale (customers only) --}}
                            @if($user->hasRole('customer'))
                                @if($user->hasWholesaleAccess())
                                    <form method="POST" action="{{ route('dashboard.users.revoke-wholesale', $user->id) }}">
                                        @csrf
                                        <button type="submit" class="btn-ws revoke" title="Revoke Wholesale">
                                            ✕ Wholesale
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('dashboard.users.grant-wholesale', $user->id) }}">
                                        @csrf
                                        <button type="submit" class="btn-ws grant" title="Grant Wholesale">
                                            ⭐ Wholesale
                                        </button>
                                    </form>
                                @endif
                            @endif

                            {{-- Delete --}}
                            <a href="{{ route('dashboard.users.user-delete', $user->id) }}"
                               class="btn-action delete"
                               title="Delete User"
                               onclick="return confirm('Delete {{ addslashes($user->name) }}? This cannot be undone.')">
                                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <polyline points="3 6 5 6 21 6"/>
                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                    <path d="M10 11v6M14 11v6"/>
                                </svg>
                            </a>

                        </div>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="6" class="empty-cell">
                        <svg fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                        </svg>
                        <div>No users found.</div>
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>

        {{-- Footer --}}
        <div class="table-footer">
            <span>Total {{ $users->total() }} users</span>
            {{ $users->links() }}
        </div>
    </div>

</div>

{{-- ── Assign Role Modal ─────────────────────────── --}}
<div class="rp-modal-wrap" id="roleModalWrap">
    <div class="rp-modal">
        <div class="rp-modal-head">
            <h5>Assign Role</h5>
            <p>Changing role for: <strong id="modalUserName"></strong></p>
        </div>
        <form id="roleForm" method="POST">
            @csrf
            @method('PUT')
            <label>Select Role</label>
            <select name="role" id="modalRoleSelect">
                @foreach($roles as $role)
                    @if(!($role->name === 'super_admin' && !auth()->user()->hasRole('super_admin')))
                        <option value="{{ $role->name }}">
                            {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                        </option>
                    @endif
                @endforeach
            </select>
            <div class="rp-modal-btns">
                <button type="button" class="btn-cancel" onclick="closeRoleModal()">Cancel</button>
                <button type="submit" class="btn-save">Save Role</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('backend_js')
<script>

    // ── Search ─────────────────────────────────────────
    document.getElementById('searchInput').addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#userTable tr').forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
        });
    });

    // ── Open Modal ─────────────────────────────────────
    function openRoleModal(userId, userName, currentRole) {
        document.getElementById('modalUserName').textContent = userName;
        document.getElementById('roleForm').action = `/dashboard/users/user-update/${userId}`;

        const select = document.getElementById('modalRoleSelect');
        for (let opt of select.options) {
            opt.selected = opt.value === currentRole;
        }

        document.getElementById('roleModalWrap').classList.add('open');
    }

    // ── Close Modal ────────────────────────────────────
    function closeRoleModal() {
        document.getElementById('roleModalWrap').classList.remove('open');
    }

    // Close when clicking outside
    document.getElementById('roleModalWrap').addEventListener('click', function (e) {
        if (e.target === this) closeRoleModal();
    });

</script>
@endpush