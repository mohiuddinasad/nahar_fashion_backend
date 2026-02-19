<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear old cached permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ----------------------------
        // CREATE ALL PERMISSIONS
        // ----------------------------
        $permissions = [
            'roles.create', 'roles.edit', 'roles.delete', 'roles.view',
            'permissions.assign', 'permissions.view',
            'users.create', 'users.edit', 'users.delete', 'users.view', 'users.assign-role',
            'products.create', 'products.edit', 'products.delete', 'products.view',
            'orders.create', 'orders.edit', 'orders.delete', 'orders.view', 'orders.update-status',
            'categories.create', 'categories.edit', 'categories.delete', 'categories.view',
            'coupons.create', 'coupons.edit', 'coupons.delete', 'coupons.view',
            'reports.view', 'reports.export',
            'settings.view', 'settings.edit',
            'superadmin.remove',
            'wholesale.access',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ----------------------------
        // CREATE ROLES + ASSIGN PERMISSIONS
        // ----------------------------

        // 1️⃣ Super Admin — gets ALL permissions
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $superAdmin->syncPermissions(Permission::all());

        // 2️⃣ Admin — gets everything EXCEPT removing Super Admin
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(
            Permission::whereNotIn('name', ['superadmin.remove'])->pluck('name')
        );

        // 3️⃣ Manager — orders + products only
        $manager = Role::firstOrCreate(['name' => 'manager']);
        $manager->syncPermissions([
            'orders.view', 'orders.create', 'orders.edit', 'orders.update-status',
            'products.view', 'products.create', 'products.edit', 'products.delete',
        ]);

        // 4️⃣ Wholesale Buyer — only wholesale access
        $wholesaleBuyer = Role::firstOrCreate(['name' => 'wholesale_buyer']);
        $wholesaleBuyer->syncPermissions(['wholesale.access']);

        // 5️⃣ Customer — no special permissions
        Role::firstOrCreate(['name' => 'customer']);

        // ----------------------------
        // CREATE DEFAULT SUPER ADMIN USER
        // ----------------------------
        $superAdminUser = User::firstOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name'     => 'Super Admin',
                'password' => bcrypt('password123'), // ⚠️ Change this in production!
            ]
        );
        $superAdminUser->assignRole('super_admin');

        $this->command->info('✅ Roles and permissions seeded!');
    }

}
