<?php

namespace Database\Seeders;

use App\Domains\Admin\Master\Permission\Models\Permission;
use App\Domains\Admin\Master\Role\Models\Role;
use Illuminate\Database\Seeder;


class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Role::all();
        
        
        foreach ($roles as $role) {
            switch ($role->id) {
                case 1:
                    $allPermissions = Permission::where('name', 'not like', 'daily_activity_log_%')->get();
                    $role->permissions()->sync($allPermissions);
                    break;

                case 2:
                    // User permission
                    $userPermissions = [
                        'project_access', 'project_view', 
                        'daily_activity_log_access', 'daily_activity_log_create', 'daily_activity_log_edit', 'daily_activity_log_delete', 'daily_activity_log_view'
                    ];
                    $userPermissionRecord = Permission::whereIn('name', $userPermissions)->get();
                    $role->permissions()->sync($userPermissionRecord);
                    break;
                default:
                    break;
            }
        }
    }
}
