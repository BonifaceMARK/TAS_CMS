<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Seed multiple sample users
        $users = [
            [
                'fullname' => 'Administrator TAS',
                'username' => 'Admin',
                'email' => 'admin@tas.com',
                'password' => Hash::make('p@s$w0rd123'),
                'email_verified_at' => now(),
                'role' => 9,
                'isactive' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fullname' => 'Administrator TAS',
                'username' => 'saint',
                'email' => 'saint@tas.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'role' => 2,
                'isactive' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'fullname' => 'Administrator TAS',
                'username' => 'mark',
                'email' => 'mark@tas.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
                'role' => 2,
                'isactive' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Add more users as needed
        ];

        // Insert each user into the users table
        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}
