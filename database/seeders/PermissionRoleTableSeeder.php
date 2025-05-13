<?php

namespace Database\Seeders;

use App\Domains\Admin\Permission\Models\Permission;
use App\Domains\Admin\Role\Models\Role;
use Illuminate\Database\Seeder;


class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Role::all();
        
        $admin_permission_ids = Permission::all();

        foreach ($roles as $role) {
            switch ($role->id) {
                case 1:
                    $role->permissions()->sync($admin_permission_ids);
                    break;
                default:
                    break;
            }
        }
    }
}
