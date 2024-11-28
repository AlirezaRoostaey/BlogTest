<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin admin',
            'email' => 'admin@appeto.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('Admin1234'),
            'role' => 'admin',
        ]);
    }
}
