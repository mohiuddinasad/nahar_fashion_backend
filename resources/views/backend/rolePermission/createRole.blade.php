@extends('backend.layout')

@section('backend_title', 'Create Role')

@section('backend_content')
@push('backend_css')
<style>
    :root {
        --primary: #4f46e5; --primary-light: #eef2ff;
        --danger: #ef4444; --dark: #1e1b4b; --gray: #6b7280;
        --border: #e5e7eb; --bg: #f9fafb; --white: #ffffff;
        --shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .rp-wrapper { padding: 24px; background: var(--bg); min-height: 100vh; }
    .page-header { display: flex; align-items: center; gap: 12px; margin-bottom: 24px; }
    .back-btn {
        display: inline-flex; align-items: center; justify-content: center;
        width: 36px; height: 36px; border-radius: 8px; background: white;
        border: 1px solid var(--border); color: var(--gray);
        text-decoration: none; font-size: 14px; transition: 0.2s;
    }
    .back-btn:hover { background: var(--primary-light); color: var(--primary); }
    .page-title { font-size: 22px; font-weight: 700; color: var(--dark); margin: 0; }
    .page-subtitle { font-size: 13px; color: var(--gray); margin: 2px 0 0; }
    .card { background: var(--white); border-radius: 12px; box-shadow: var(--shadow); overflow: hidden; max-width: 900px; }
    .card-header { padding: 18px 24px; border-bottom: 1px solid var(--border); background: #f8f9ff; }
    .card-header h2 { font-size: 16px; font-weight: 700; color: var(--dark); margin: 0; }
    .card-body { padding: 24px; }
    .form-group { margin-bottom: 22px; }
    .form-label { display: block; font-size: 13px; font-weight: 600; color: var(--dark); margin-bottom: 6px; }
    .form-label span { color: var(--danger); }
    .form-control {
        width: 100%; padding: 10px 14px; border: 1px solid var(--border);
        border-radius: 8px; font-size: 14px; color: #374151;
        background: white; box-sizing: border-box; transition: 0.2s;
    }
    .form-control:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(79,70,229,0.1); }
    .form-error { font-size: 12px; color: var(--danger); margin-top: 4px; }
    .perm-section-title { font-size: 13px; font-weight: 700; color: var(--dark); margin-bottom: 14px; display: flex; align-items: center; justify-content: space-between; }
    .select-all-btn { font-size: 12px; color: var(--primary); background: none; border: none; cursor: pointer; font-weight: 600; padding: 0; }
    .perm-groups { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 16px; }
    .perm-group { border: 1px solid var(--border); border-radius: 10px; overflow: hidden; }
    .perm-group-header { padding: 10px 14px; background: #f8f9ff; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
    .perm-group-title { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: var(--primary); display: flex; align-items: center; gap: 6px; }
    .perm-items { padding: 10px 14px; display: flex; flex-direction: column; gap: 8px; }
    .perm-item { display: flex; align-items: center; gap: 8px; cursor: pointer; }
    .perm-item input[type="checkbox"] { width: 15px; height: 15px; accent-color: var(--primary); cursor: pointer; }
    .perm-item label { font-size: 13px; color: #374151; cursor: pointer; user-select: none; }
    .form-actions { display: flex; gap: 10px; margin-top: 28px; padding-top: 20px; border-top: 1px solid var(--border); }
    .btn-submit { display: inline-flex; align-items: center; gap: 6px; background: var(--primary); color: white; border: none; padding: 11px 24px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: 0.2s; }
    .btn-submit:hover { background: #4338ca; }
    .btn-cancel-link { display: inline-flex; align-items: center; gap: 6px; background: white; color: var(--gray); border: 1px solid var(--border); padding: 11px 24px; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; }
    .btn-cancel-link:hover { background: var(--bg); }
</style>

@endpush
<div class="rp-wrapper">

    <div class="page-header">
        <a href="{{ route('dashboard.role-permission.role-list') }}" class="back-btn">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="page-title">Create New Role</h1>
            <p class="page-subtitle">Define a role and assign permissions</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2><i class="fas fa-shield-alt" style="color:var(--primary);margin-right:8px;"></i> Role Details</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.role-permission.role-store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label">Role Name <span>*</span></label>
                    <input type="text" name="name" class="form-control"
                           placeholder="e.g. editor, moderator"
                           value="{{ old('name') }}" required>
                    @error('name')
                        <p class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="perm-section-title">
                        <span><i class="fas fa-key" style="color:var(--primary);margin-right:6px;"></i> Assign Permissions</span>
                        <button type="button" class="select-all-btn" onclick="toggleAll(this)">Select All</button>
                    </div>

                    @php
                        $grouped = $permissions->groupBy(fn($p) => explode('.', $p->name)[0]);
                        $icons = [
                            'roles'       => 'fa-shield-alt',
                            'permissions' => 'fa-key',
                            'users'       => 'fa-users',
                            'products'    => 'fa-box',
                            'orders'      => 'fa-shopping-bag',
                            'categories'  => 'fa-tags',
                            'coupons'     => 'fa-ticket-alt',
                            'reports'     => 'fa-chart-bar',
                            'settings'    => 'fa-cog',
                        ];
                    @endphp

                    <div class="perm-groups">
                        @foreach($grouped as $group => $perms)
                        <div class="perm-group">
                            <div class="perm-group-header">
                                <span class="perm-group-title">
                                    <i class="fas {{ $icons[$group] ?? 'fa-circle' }}"></i>
                                    {{ ucfirst($group) }}
                                </span>
                                <input type="checkbox" onchange="toggleGroup(this, '{{ $group }}')">
                            </div>
                            <div class="perm-items">
                                @foreach($perms as $permission)
                                <label class="perm-item">
                                    <input type="checkbox"
                                           name="permissions[]"
                                           value="{{ $permission->name }}"
                                           data-group="{{ $group }}"
                                           {{ in_array($permission->name, old('permissions', [])) ? 'checked' : '' }}>
                                    <label>{{ ucfirst(str_replace(['.','_'], [' → ',' '], $permission->name)) }}</label>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>

                    @error('permissions')
                        <p class="form-error" style="margin-top:10px;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i> Create Role
                    </button>
                    <a href="{{ route('dashboard.role-permission.role-list') }}" class="btn-cancel-link">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('backend_js')
<script>
    function toggleAll(btn) {
        const checkboxes = document.querySelectorAll('input[name="permissions[]"]');
        const allChecked = [...checkboxes].every(c => c.checked);
        checkboxes.forEach(c => c.checked = !allChecked);
        btn.textContent = allChecked ? 'Select All' : 'Deselect All';
        document.querySelectorAll('.perm-group-header input[type="checkbox"]')
            .forEach(g => g.checked = !allChecked);
    }
    function toggleGroup(checkbox, group) {
        document.querySelectorAll(`input[data-group="${group}"]`)
            .forEach(c => c.checked = checkbox.checked);
    }
</script>

@endpush
@endsection
