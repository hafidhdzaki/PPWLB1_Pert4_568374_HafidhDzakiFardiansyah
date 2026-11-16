<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Project;
use Illuminate\Support\Str;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryIds = Category::pluck('id')->all();

        for ($i = 1; $i <= 25; $i++){
            $title = 'Project ' . Str::upper(Str::random(5));

            Project::create([
                'title'             => $title,
                'slug'              => Str::slug($title) . '-' . $i,
                'short_description' => 'Ringkasan singkat untuk ' . $title,
                'tools'             => 'Laravel, Tailwind, MySQL',
                'description'       => 'Ini adalah project ke-' . $i,
                'status'            => 'published',
                'project_date'      => now()->subDays($i * 3),
                'category_id'       => $categoryIds ? $categoryIds[($i - 1) % count($categoryIds)] : null,
            ]);
        }
    }
}
