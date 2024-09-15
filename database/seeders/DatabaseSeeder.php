<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $data = [
            [
                'name' => 'John Doe 1',
                'email' => 'example1@gmail.com',
                'position' => 1,
                'password' => bcrypt('password')
            ],
            [
                'name' => 'John Doe 2',
                'email' => 'example2@gmail.com',
                'position' => 2,
                'password' => bcrypt('password')
            ],
            [
                'name' => 'John Doe 3',
                'email' => 'example3@gmail.com',
                'position' => 3,
                'password' => bcrypt('password')
            ],
        ];

        User::insert($data);
    }
}
