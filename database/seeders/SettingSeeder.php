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
                'key'           => 'terms_condition',
                'value'         => null,
                'type'          => 'file',
                'details'       => null,
                'display_name'  =>'Terms And Condition',
                'group'         => 'api',
                'status'        => 1,
                'position'      => 4,
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'created_by'    => 1,
            ],
            [
                'key'           => 'privacy_policy',
                'value'         => null,
                'type'          => 'file',
                'display_name'  => 'Privacy Policy',
                'group'         => 'api',
                'details' => null,
                'status'        => 1,
                'position'      => 5,
                'created_at'    => Carbon::now()->format('Y-m-d H:i:s'),
                'created_by'    => 1,
            ],
            [
                'key'    => 'support_name',
                'value'  => 'Socail Network Analyzer Support',
                'type'   => 'text',
                'display_name'  => 'Contact Name',
                'group'  => 'support',
                'details' => null,
                'status' => 1,
                'position' => 6,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_by' => 1,
            ],
            [
                'key'    => 'support_email',
                'value'  => 'support@gmail.com',
                'type'   => 'email',
                'display_name'  => 'Contact Email',
                'group'  => 'support',
                'details' => null,
                'status' => 1,
                'position' => 7,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_by' => 1,
            ],
        ];
        Setting::insert($settings);
    }
}