<?php

namespace Database\Seeders;

use App\Domains\Admin\User\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name'           => 'Super Admin',
                'email'          => 'superadmin@gmail.com',
                'phone'          => '1523647890',
                'password'       => bcrypt('12345678'),
                'remember_token' => null,
                'email_verified_at' => date('Y-m-d H:i:s'),
            ],
            // [
            //     'company_id'     => 2,
            //     'name'           => "Klive's Kitchen",
            //     'email'          => 'klivekitchen@gmail.com',
            //     'phone'          => '8888777722',
            //     'is_active'      => 1,
            //     'password'       => bcrypt('12345678'),
            //     'remember_token' => null,
            //     'email_verified_at' => date('Y-m-d H:i:s'),
            //     'created_by'     => 1,
            // ],
        ];
        foreach($users as $key=>$user){
            $createdUser =  User::create($user);
        }
    }
}
