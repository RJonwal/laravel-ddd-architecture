<?php

namespace Database\Seeders;

use App\Domains\Admin\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $updateDate = $createDate = date('Y-m-d H:i:s');
        $permissions = [
            [
                'name'       => 'role_access',
                'title'      => 'Menu Access',
                'route_name' => 'roles',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'role_edit',
                'title'      => 'Edit',
                'route_name' =>'roles',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'role_show',
                'title'      => 'View',
                'route_name' => 'roles',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'profile_access',
                'title'      => 'View',
                'route_name' => 'profile',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'profile_edit',
                'title'      => 'Edit',
                'route_name' => 'profile',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'change_password',
                'title'      => 'Change Password',
                'route_name' => 'profile',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'setting_access',
                'title'      => 'Setting Menu Access',
                'route_name' =>'settings',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'setting_edit',
                'title'      => 'Edit',
                'route_name' =>'settings',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'user_access',
                'title'      => 'User Menu Access',
                'route_name' => 'users',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'user_create',
                'title'      => 'User Menu Access',
                'route_name' => 'users',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'user_edit',
                'title'      => 'User Menu Access',
                'route_name' => 'users',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

            [
                'name'       => 'user_view',
                'title'      => 'Delete',
                'route_name' => 'users',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'user_delete',
                'title'      => 'Delete',
                'route_name' => 'users',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'user_status',
                'title'      => 'Status',
                'route_name' => 'users',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
        ];
        Permission::insert($permissions);
    }
}
