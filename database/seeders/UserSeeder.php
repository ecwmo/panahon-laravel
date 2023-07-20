<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            [
                'id' => 1,
                'name' => "USER",
                'description' => "user role"
            ],
            [
                'id' => 2,
                'name' => "ADMIN",
                'description' => "admin role"
            ],
            [
                'id' => 3,
                'name' => "SUPERADMIN",
                'description' => "super admin role"
            ]
        ]);

        User::insert([
            [
                'id' => 1,
                'username' => "admin",
                'full_name' => "Admin User",
                'email' => "admin@panahon.ph",
                'password' => Hash::make("1@mAdmin")
            ],
            [
                'id' => 2,
                'username' => "user1",
                'full_name' => "User",
                'email' => "user1@panahon.ph",
                'password' => Hash::make("user1p@ss")
            ]
        ]);

        $user = User::find(1);
        $user->roles()->attach(2);
        $user->roles()->attach(3);

        $user = User::find(2);
        $user->roles()->attach(1);
    }
}
