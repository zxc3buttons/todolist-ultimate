<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 12; $i <= 22; $i++) {
            DB::table('users')->insert([
                'id' => $i,
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@example.com',
                'password' => Hash::make('password'),
                'profile_photo_link' => null,
                'bio' => null,
                'job_sphere' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
