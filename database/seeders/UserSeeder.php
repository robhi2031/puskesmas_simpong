<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Admin Sample',
            'username' => 'admin.sample',
            'password' => bcrypt('123456'),
            'email' => 'admin.sample@gmail.com',
            'phone_number' => '0',
            'thumb' => 'avatar-sample-01.jpg',
            'user_add' => 1,
        ]);

        $role = Role::create([
            'name' => 'Super Admin',
            'guard_name' => 'web',
            'user_add' => 1,
        ]);

        $permissionMenu = DB::table('permission_has_menus')->insert([
            'name' => 'SETTINGS',
            'icon' => 'bi-gear',
            'has_route' => 'N',
            'route_name' => NULL,
            'has_child' => 'Y',
            'is_crud' => 'N',
            'order_line' => '1',
            'user_add' => 1,
        ]);
        $permissionMenu = DB::table('permission_has_menus')->insert([
            'name' => 'Site Info',
            'icon' => NULL,
            'has_route' => 'Y',
            'route_name' => 'manage_siteinfo',
            'parent_id' => 1,
            'has_child' => 'N',
            'is_crud' => 'N',
            'order_line' => '1.1',
            'user_add' => 1,
        ]);
        $permissionMenu = DB::table('permission_has_menus')->insert([
            'name' => 'Roles',
            'icon' => NULL,
            'has_route' => 'Y',
            'route_name' => 'manage_roles',
            'parent_id' => 1,
            'has_child' => 'N',
            'is_crud' => 'Y',
            'order_line' => '1.2',
            'user_add' => 1,
        ]);
        $permissionMenu = DB::table('permission_has_menus')->insert([
            'name' => 'Permissions',
            'icon' => NULL,
            'has_route' => 'Y',
            'route_name' => 'manage_permissions',
            'parent_id' => 1,
            'has_child' => 'N',
            'is_crud' => 'Y',
            'order_line' => '1.3',
            'user_add' => 1,
        ]);

        $permission = Permission::create([
            'name' => 'setings-read',
            'fid_menu' => 1,
            'guard_name' => 'web',
            'user_add' => 1,
        ]);
        $permission = Permission::create([
            'name' => 'site-info-read',
            'fid_menu' => 2,
            'guard_name' => 'web',
            'user_add' => 1,
        ]);
        $permission = Permission::create([
            'name' => 'site-info-update',
            'fid_menu' => 2,
            'guard_name' => 'web',
            'user_add' => 1,
        ]);
        $permission = Permission::create([
            'name' => 'roles-read',
            'fid_menu' => 3,
            'guard_name' => 'web',
            'user_add' => 1,
        ]);
        $permission = Permission::create([
            'name' => 'roles-create',
            'fid_menu' => 3,
            'guard_name' => 'web',
            'user_add' => 1,
        ]);
        $permission = Permission::create([
            'name' => 'roles-update',
            'fid_menu' => 3,
            'guard_name' => 'web',
            'user_add' => 1,
        ]);
        $permission = Permission::create([
            'name' => 'roles-delete',
            'fid_menu' => 3,
            'guard_name' => 'web',
            'user_add' => 1,
        ]);
        $permission = Permission::create([
            'name' => 'permissions-read',
            'fid_menu' => 4,
            'guard_name' => 'web',
            'user_add' => 1,
        ]);
        $permission = Permission::create([
            'name' => 'permissions-create',
            'fid_menu' => 4,
            'guard_name' => 'web',
            'user_add' => 1,
        ]);
        $permission = Permission::create([
            'name' => 'permissions-update',
            'fid_menu' => 4,
            'guard_name' => 'web',
            'user_add' => 1,
        ]);
        $permission = Permission::create([
            'name' => 'permissions-delete',
            'fid_menu' => 4,
            'guard_name' => 'web',
            'user_add' => 1,
        ]);
        // $permissions = Permission::pluck('id','id')->all();
        // $role->syncPermissions($permissions);
        $role->givePermissionTo('setings-read');
        $role->givePermissionTo('site-info-read');
        $role->givePermissionTo('site-info-update');
        $role->givePermissionTo('roles-read');
        $role->givePermissionTo('roles-create');
        $role->givePermissionTo('roles-update');
        $role->givePermissionTo('roles-delete');
        $role->givePermissionTo('permissions-read');
        $role->givePermissionTo('permissions-create');
        $role->givePermissionTo('permissions-update');
        $role->givePermissionTo('permissions-delete');

        $user->assignRole([$role->id]);
    }
}
