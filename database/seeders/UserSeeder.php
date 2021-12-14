<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        \DB::table('users')->insert([
            'name' => 'User 1',
            'email' => 'user1@user.com',
            'password' => Hash::make('password'),
            'reward_points' => 500,
        ]);
        \DB::table('users')->insert([
            'name' => 'User 2',
            'email' => 'user2@user.com',
            'password' => Hash::make('password'),
        ]);
        \DB::table('users')->insert([
            'name' => 'User 3',
            'email' => 'user3@user.com',
            'password' => Hash::make('password'),
        ]);
    }
}
