<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Category;
use App\Models\Technology;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $isAdmin = Auth::check() && Auth::user()->role === 'admin';

        $query = Project::with(['category', 'technologies'])
            // Publik hanya melihat published; Admin bisa filter status (published/draft/semua)
            ->when(!$isAdmin, fn ($q) => $q->where('status', 'published'))
            ->when($isAdmin && $request->filled('status'), fn ($q) => $q->where('status', $request->status))
            // Pencarian pada title, short_description, dan description
            ->when($request->search, fn ($q, $s) =>
                $q->where(fn ($w) => $w->where('title', 'like', "%{$s}%")
                    ->orWhere('short_description', 'like', "%{$s}%")
                    ->orWhere('description', 'like', "%{$s}%")))
            // Filter relasi category berdasarkan slug
            ->when($request->category, fn ($q, $c) =>
                $q->whereHas('category', fn ($w) => $w->where('slug', $c)))
            // Filter relasi technology berdasarkan slug (Latihan)
            ->when($request->technology, fn ($q, $t) =>
                $q->whereHas('technologies', fn ($w) => $w->where('slug', $t)));

        // Sorting dinamis termasuk berdasarkan project_date (Latihan)
        switch ($request->query('sort')) {
            case 'terlama':
                $query->oldest();
                break;
            case 'az':
                $query->orderBy('title');
                break;
            case 'tanggal_terbaru':
                $query->orderByDesc('project_date');
                break;
            case 'tanggal_terlama':
                $query->orderBy('project_date');
                break;
            default:
                $query->latest();
        }

        $perPage = in_array((int) $request->query('per_page'), [5, 9, 10, 25])
            ? (int) $request->query('per_page')
            : 9;

        $projects = $query->paginate($perPage)->withQueryString();
        $categories = Category::orderBy('name')->get();
        $technologies = Technology::orderBy('name')->get();

        return view('projects.index', compact('projects', 'categories', 'technologies'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $technologies = Technology::orderBy('name')->get();

        return view('projects.create', compact('categories', 'technologies'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'             => 'required|string|min:5|max:255|unique:projects,title',
            'category_id'       => 'required|exists:categories,id',
            'short_description' => 'nullable|string|max:255',
            'tools'             => 'required|string',
            'description'       => 'required|string|min:10',
            'status'            => 'required|in:published,draft',
            'project_date'      => 'nullable|date',
            'is_featured'       => 'nullable|boolean',
            'project_url'       => 'nullable|url|max:255',
            'repository_url'    => 'nullable|url|max:255',
            'thumbnail'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048|dimensions:min_width=400,min_height=300',
            'technologies'      => 'nullable|array',
            'technologies.*'    => 'exists:technologies,id',
        ]);

        $validatedData['slug'] = $this->generateUniqueSlug($validatedData['title']);
        $validatedData['is_featured'] = $request->boolean('is_featured');

        $technologyIds = $validatedData['technologies'] ?? [];
        unset($validatedData['technologies']);

        if ($request->hasFile('thumbnail')) {
            $validatedData['thumbnail'] = $request->file('thumbnail')
                ->store('projects/thumbnails', 'public');
        }

        $project = Project::create($validatedData);
        $project->technologies()->attach($technologyIds);

        return redirect()->route('projects.index')
            ->with('success', 'Project telah berhasil ditambahkan.');
    }

    public function show(Project $project)
    {
        $isAdmin = Auth::check() && Auth::user()->role === 'admin';
        abort_if(!$isAdmin && $project->status !== 'published', 404);

        $project->load(['category', 'technologies', 'images']);

        return view('projects.show', [
            'id'       => 'projects',
            'projects' => $project,
        ]);
    }

    public function edit(string $id)
    {
        $project = Project::with('technologies')->findOrFail($id);
        $categories = Category::orderBy('name')->get();
        $technologies = Technology::orderBy('name')->get();

        return view('projects.edit', compact('project', 'categories', 'technologies'));
    }

    public function update(Request $request, string $id)
    {
        $project = Project::findOrFail($id);

        $validatedData = $request->validate([
            'title'             => ['required', 'string', 'min:5', 'max:255', Rule::unique('projects', 'title')->ignore($project->id)],
            'category_id'       => 'required|exists:categories,id',
            'short_description' => 'nullable|string|max:255',
            'tools'             => 'required|string',
            'description'       => 'required|string|min:10',
            'status'            => 'required|in:published,draft',
            'project_date'      => 'nullable|date',
            'is_featured'       => 'nullable|boolean',
            'project_url'       => 'nullable|url|max:255',
            'repository_url'    => 'nullable|url|max:255',
            'thumbnail'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048|dimensions:min_width=400,min_height=300',
            'technologies'      => 'nullable|array',
            'technologies.*'    => 'exists:technologies,id',
        ]);

        $validatedData['slug'] = $this->generateUniqueSlug($validatedData['title'], $project->id);
        $validatedData['is_featured'] = $request->boolean('is_featured');

        $technologyIds = $validatedData['technologies'] ?? [];
        unset($validatedData['technologies']);

        if ($request->hasFile('thumbnail')) {
            if ($project->thumbnail) {
                Storage::disk('public')->delete($project->thumbnail);
            }
            $validatedData['thumbnail'] = $request->file('thumbnail')
                ->store('projects/thumbnails', 'public');
        }

        $project->update($validatedData);
        $project->technologies()->sync($technologyIds);

        return redirect()->route('projects.index')
            ->with('success', 'Project berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);

        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project berhasil dihapus.');
    }

    private function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title) ?: 'project';
        $slug = $baseSlug;
        $counter = 1;

        while (Project::withTrashed()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
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
