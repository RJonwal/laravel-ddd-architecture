<?php

namespace Database\Seeders;

use App\Domains\Admin\User\Models\User;
use Illuminate\Database\Seeder;


class RoleUserTableSeeder extends Seeder
{
    public function run()
    {
        User::findOrFail(1)->roles()->sync(1);
        
    }
}
