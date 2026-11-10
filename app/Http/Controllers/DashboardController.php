<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Category;
use App\Models\Technology;
use App\Models\Skill;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalProjects'     => Project::count(),
            'totalCategories'   => Category::count(),
            'latestProjects'    => Project::latest()->take(5)->get(),
        ]);
    }
}
