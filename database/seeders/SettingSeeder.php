<?php

namespace Database\Seeders;

use App\Domains\Admin\Setting\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key'           => 'site_title',
                'value'         => 'Task Manager',
                'type'          => 'text',
                'display_name'  => 'Site Title',
                'group'         => 'web',
                'details'       => null,
                'status'        => 1,
                'position'      => 1,
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'created_by'    => 1,
            ],
            [
                'key'           => 'site_logo',
                'value'         => null,
                'type'          => 'image',
                'details'       => null,
                'display_name'  => 'Site Logo',
                'group'         => 'web',
                'status'        => 1,
                'position'      => 2,
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'created_by'    => 1,
            ],
            [
                'key'           => 'favicon',
                'value'         => null,
                'type'          => 'image',
                'details'       => null,
                'display_name'  =>'Favicon Icon',
                'group'         => 'web',
                'status'        => 1,
                'position'      => 3,
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'created_by'    => 1,
            ],
            [
                'key'           => 'user_pagination',
                'value'         => 25,
                'type'          => 'text',
                'details'       => null,
                'display_name'  =>'User',
                'group'         => 'support',
                'status'        => 1,
                'position'      => 1,
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'created_by'    => 1,
            ],
            [
                'key'           => 'technology_pagination',
                'value'         => 25,
                'type'          => 'text',
                'display_name'  => 'Technology',
                'group'         => 'support',
                'details'       => null,
                'status'        => 1,
                'position'      => 2,
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'created_by'    => 1,
            ],
            [
                'key'           => 'project_pagination',
                'value'         => 25,
                'type'          => 'text',
                'display_name'  => 'Project',
                'group'         => 'support',
                'details'       => null,
                'status'        => 1,
                'position'      => 3,
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'created_by'    => 1,
            ],
            [
                'key'           => 'milestone_pagination',
                'value'         => 25,
                'type'          => 'text',
                'display_name'  => 'Milestone',
                'group'         => 'support',
                'details'       => null,
                'status'        => 1,
                'position'      => 4,
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'created_by'    => 1,
            ],
            [
                'key'           => 'sprint_pagination',
                'value'         => 25,
                'type'          => 'text',
                'display_name'  => 'Sprint',
                'group'         => 'support',
                'details'       => null,
                'status'        => 1,
                'position'      => 5,
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'created_by'    => 1,
            ],
            [
                'key'           => 'task_pagination',
                'value'         => 25,
                'type'          => 'text',
                'display_name'  => 'Task',
                'group'         => 'support',
                'details'       => null,
                'status'        => 1,
                'position'      => 6,
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'created_by'    => 1,
            ],
            [
                'key'           => 'daily_task_pagination',
                'value'         => 25,
                'type'          => 'text',
                'display_name'  => 'Daily Task',
                'group'         => 'support',
                'details'       => null,
                'status'        => 1,
                'position'      => 7,
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'created_by'    => 1,
            ]
        ];
        Setting::insert($settings);
    }
}