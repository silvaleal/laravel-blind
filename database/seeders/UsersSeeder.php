<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                "name" => "teste1",
                "email" => "teste1@email.com",
                "password" => Hash::make("Mypassword@1")
            ]
        ];

        foreach ($users as $user) {
            try {
                User::create($user);
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        }

    }
}
