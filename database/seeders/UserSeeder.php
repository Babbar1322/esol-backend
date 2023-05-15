<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::create([
            "name" => "Gursahb Singh",
            "email" => "gs@gmail.com",
            "phone" => "1234567890",
            "password" => Hash::make("11"),
            "show_pass" => "11",
        ]);
    }
}
