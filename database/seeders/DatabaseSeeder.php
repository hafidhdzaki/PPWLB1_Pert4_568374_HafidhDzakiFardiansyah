<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name'     => 'Admin Portofolio',
            'email'    => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'User Pengunjung',
            'email'    => 'user@example.com',
            'password' => Hash::make('password123'),
            'role'     => 'user',
        ]);

        $this->call([
            ProjectTableSeeder::class,
        ]);
    }
}
