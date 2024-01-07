<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            "name" => "staff",
            "email" => "staff1@gmail.com",
            "password" => Hash::make("stafftu"),
            "role" => "staff",
        ]);
        User::create([
            "name" => "guru",
            "email" => "guru1@gmail.com",
            "password" => Hash::make("gurutu"),
            "role" => "guru",
        ]);
    }
}
