<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'password' => 'admin123',
            'role' => 'admin',
        ]);

        User::create([
            'username' => 'sammi',
            'password' => 'password',
            'role' => 'user',
        ]);

        $this->call([
            ChecklistItemSeeder::class,
            QuizSeeder::class,
        ]);
    }
}
