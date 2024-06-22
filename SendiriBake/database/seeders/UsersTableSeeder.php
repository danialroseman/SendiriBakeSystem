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
        DB::table('users')->insert([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'), // Replace 'password' with your desired password
            'is_admin' => true, // Example of setting an admin user
            'remember_token' => null, // Or generate a remember token if needed
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // You can add more users as needed
    }
}
