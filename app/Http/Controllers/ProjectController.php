<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $query = Project::published();

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        $projects = $query->with('category')->paginate($perPage)->withQueryString();

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('projects.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'       => 'required|string|min:5',
            'tools'       => 'required|string',
            'description' => 'required|string|min:10',
            'status'      => 'required|in:published,draft',
            'category_id' => 'required|exists:categories,id',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048|dimensions:min_width=400,min_height=300',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validatedData['thumbnail'] = $request->file('thumbnail')
                ->store('projects/thumbnails', 'public');
        }

        Project::create($validatedData);

        return redirect()->route('projects.index')
            ->with('success', 'Project telah berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $project = Project::with(['category', 'images'])->findOrFail($id);

        $data = array(
            'id'       => 'projects',
            'projects' => $project
        );
        return view('projects.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $project = Project::findOrFail($id);
        $categories = Category::all();
        $data = [
            'project'    => $project,
            'categories' => $categories,
        ];
        return view('projects.edit', $data);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'title'       => 'required|string|min:5',
            'tools'       => 'required|string',
            'description' => 'required|string|min:10',
            'status'      => 'required|in:published,draft',
            'category_id' => 'required|exists:categories,id',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048|dimensions:min_width=400,min_height=300',
        ]);

        $project = Project::findOrFail($id);
        if ($request->hasFile('thumbnail')) {
            if ($project->thumbnail) {
                Storage::disk('public')->delete($project->thumbnail);
            }

            $validatedData['thumbnail'] = $request->file('thumbnail')
                ->store('projects/thumbnails', 'public');
        }

        $project->update($validatedData);

        return redirect()->route('projects.index')
            ->with('success', 'Project berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);

        if ($project->thumbnail) {
            Storage::disk('public')->delete($project->thumbnail);
        }

        if ($project->images) {
            foreach ($project->images as $image) {
                Storage::disk('public')->delete($image->image);
            }
        }

        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project berhasil dihapus.');
    }

    public function trash(){
        $data = array(
            'projects' => Project::onlyTrashed()->get()
        );
        return view('projects.trash')->with($data);
    }

    public function restore($id){
        $project = Project::withTrashed()->findOrFail($id);
        $project->restore();
        return redirect()->route('projects.trash')->with('success', 'Project berhasil dipulihkan');
    }

    public function forceDelete($id){
        $project = Project::withTrashed()->findOrFail($id);

        if ($project->thumbnail) {
            Storage::disk('public')->delete($project->thumbnail);
        }
        if ($project->images) {
            foreach ($project->images as $image) {
                Storage::disk('public')->delete($image->image);
            }
        }

        $project->forceDelete();
        return redirect()->route('projects.trash')->with('success', 'Project berhasil dihapus permanen');
    }
}
