<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Technology;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        foreach (['Web Development', 'Mobile App', 'UI/UX Design'] as $name) {
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }

        foreach (['Laravel', 'PHP', 'MySQL', 'JavaScript', 'Tailwind CSS', 'Docker'] as $name) {
            Technology::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }

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
