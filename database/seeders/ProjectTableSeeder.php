<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use Illuminate\Support\Str;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 25; $i++){
            Project::create([
                'title' => 'Project ' . Str::upper(Str::random(5)),
                'tools' => 'Laravel, Tailwind, MySQL',
                'description' => 'Ini adalah project ke-' . $i,
                'status'  => 'published'
            ]);
        }
    }
}
