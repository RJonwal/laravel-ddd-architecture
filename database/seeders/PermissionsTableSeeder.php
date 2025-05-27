<?php

namespace Database\Seeders;

use App\Domains\Admin\Master\Permission\Models\Permission;
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

            // Technology permissions
            [
                'name'       => 'technology_access',
                'title'      => 'Technology Menu Access',
                'route_name' => 'technologies',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'technology_create',
                'title'      => 'Technology Menu Access',
                'route_name' => 'technologies',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'technology_edit',
                'title'      => 'Technology Menu Access',
                'route_name' => 'technologies',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

            [
                'name'       => 'technology_view',
                'title'      => 'Delete',
                'route_name' => 'technologies',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'technology_delete',
                'title'      => 'Delete',
                'route_name' => 'technologies',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

            // Project permissions
            [
                'name'       => 'project_access',
                'title'      => 'Project Menu Access',
                'route_name' => 'projects',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'project_create',
                'title'      => 'Project Menu Access',
                'route_name' => 'projects',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'project_edit',
                'title'      => 'Project Menu Access',
                'route_name' => 'projects',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

            [
                'name'       => 'project_view',
                'title'      => 'Delete',
                'route_name' => 'projects',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'project_delete',
                'title'      => 'Delete',
                'route_name' => 'projects',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

            // Daily Task log permissions
            [
                'name'       => 'daily_activity_log_access',
                'title'      => 'Project Menu Access',
                'route_name' => 'daily_activity_logs',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'daily_activity_log_create',
                'title'      => 'Project Menu Access',
                'route_name' => 'daily_activity_logs',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'daily_activity_log_edit',
                'title'      => 'Project Menu Access',
                'route_name' => 'daily_activity_logs',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

            [
                'name'       => 'daily_activity_log_view',
                'title'      => 'Delete',
                'route_name' => 'daily_activity_logs',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'daily_activity_log_delete',
                'title'      => 'Delete',
                'route_name' => 'daily_activity_logs',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

            [
                'name'       => 'milestone_access',
                'title'      => 'Milestone Menu Access',
                'route_name' => 'milestones',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'milestone_create',
                'title'      => 'Milestone Menu Access',
                'route_name' => 'milestones',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'milestone_edit',
                'title'      => 'Milestone Menu Access',
                'route_name' => 'milestones',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

            [
                'name'       => 'milestone_view',
                'title'      => 'Delete',
                'route_name' => 'milestones',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'milestone_delete',
                'title'      => 'Delete',
                'route_name' => 'milestones',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

            [
                'name'       => 'task_access',
                'title'      => 'Task Menu Access',
                'route_name' => 'tasks',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'task_create',
                'title'      => 'Task Menu Access',
                'route_name' => 'tasks',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'task_edit',
                'title'      => 'Task Menu Access',
                'route_name' => 'tasks',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

            [
                'name'       => 'task_view',
                'title'      => 'Delete',
                'route_name' => 'tasks',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'task_delete',
                'title'      => 'Delete',
                'route_name' => 'tasks',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],

            // Admin Activity Permission
            [
                'name'       => 'admin_daily_activity_log_access',
                'title'      => 'Daily Activity Logs Menu Access',
                'route_name' => 'daily_activity_logs',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
            [
                'name'       => 'admin_daily_activity_log_view',
                'title'      => 'Delete',
                'route_name' => 'daily_activity_logs',
                'type'       => 'backend',
                'created_at' => $createDate,
                'updated_at' => $updateDate,
            ],
        ];
        Permission::insert($permissions);
    }
}
