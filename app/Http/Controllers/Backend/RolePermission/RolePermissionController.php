<?php

namespace App\Http\Controllers\Backend\RolePermission;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionController extends Controller
{
    // ── User List ─────────────────────────────────────
    public function userList()
    {
        $users = User::with('roles')
            ->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'super_admin');
            })
            ->latest()
            ->paginate(15);

        $roles = Role::all();

        return view('backend.rolePermission.userList', compact('users', 'roles'));
    }

    // ── Update User Role ────────────────────────────── ✅ THIS WAS MISSING
    public function userUpdate(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|string|exists:roles,name',
        ]);

        $user = User::findOrFail($id);

        // Cannot change your own role
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot change your own role.');
        }

        // Only Super Admin can change another Super Admin's role
        if ($user->hasRole('super_admin')) {
            Gate::authorize('remove-super-admin');
        }

        $user->syncRoles([$request->role]);

        return back()->with('success', "{$user->name}'s role updated to '{$request->role}'.");
    }

    // ── Delete User ───────────────────────────────────
    public function userDelete($id)
    {
        $user = User::findOrFail($id);

        // Cannot delete yourself
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        // Only Super Admin can delete another Super Admin
        if ($user->hasRole('super_admin')) {
            Gate::authorize('remove-super-admin');
        }

        $user->delete();

        return redirect()->route('dashboard.users.user-list')
            ->with('success', 'User deleted successfully.');
    }

    // ── Role List ─────────────────────────────────────
    public function roleList()
    {
        $roles = Role::with('permissions')->get();

        return view('backend.rolePermission.roleList', compact('roles'));
    }

    // ── Create Role Form ──────────────────────────────
    public function roleCreate()
    {
        $permissions = Permission::all();

        return view('backend.rolePermission.createRole', compact('permissions'));
    }

    // ── Store New Role ────────────────────────────────
    public function roleStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:roles,name|max:100',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role = Role::create(['name' => $request->name]);

        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('dashboard.role-permission.role-list')
            ->with('success', "Role '{$role->name}' created successfully.");
    }

    // ── Edit Role Form ────────────────────────────────
    public function roleEdit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::all();

        return view('backend.rolePermission.editRole', compact('role', 'permissions'));
    }

    // ── Update Role ───────────────────────────────────
    public function roleUpdate(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        if (! in_array($role->name, ['super_admin', 'admin', 'manager', 'customer', 'wholesale_buyer'])) {
            $request->validate([
                'name' => 'required|string|max:100|unique:roles,name,'.$role->id,
            ]);
            $role->update(['name' => $request->name]);
        }

        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $role->syncPermissions($request->permissions ?? []);

        return redirect()->route('dashboard.role-permission.role-list')
            ->with('success', "Role '{$role->name}' updated successfully.");
    }

    // ── Delete Role ───────────────────────────────────
    public function roleDelete($id)
    {
        $role = Role::findOrFail($id);

        if (in_array($role->name, ['super_admin', 'admin', 'manager', 'customer', 'wholesale_buyer'])) {
            return back()->with('error', 'Core roles cannot be deleted.');
        }

        $role->delete();

        return redirect()->route('dashboard.role-permission.role-list')
            ->with('success', 'Role deleted successfully.');
    }

    // ── Grant Wholesale ───────────────────────────────
    public function grantWholesale($id)
    {
        $user = User::findOrFail($id);

        if (! $user->hasRole('customer')) {
            return back()->with('error', 'Wholesale access can only be granted to customers.');
        }

        $user->grantWholesaleAccess();

        return back()->with('success', "{$user->name} now has wholesale access.");
    }

    // ── Revoke Wholesale ──────────────────────────────
    public function revokeWholesale($id)
    {
        $user = User::findOrFail($id);
        $user->revokeWholesaleAccess();

        return back()->with('success', "Wholesale access revoked for {$user->name}.");
    }
}