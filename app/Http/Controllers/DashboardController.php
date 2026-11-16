<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $isAdmin = Auth::user()?->role === 'admin';

        $projectsQuery = Project::query()
            ->when(! $isAdmin, fn ($query) => $query->where('status', 'published'));

        return view('dashboard', [
            'isAdmin'           => $isAdmin,
            'totalProjects'     => (clone $projectsQuery)->count(),
            'totalCategories'   => Category::count(),
            'latestProjects'    => $projectsQuery->with('category')->latest()->take(5)->get(),
        ]);
    }
}
