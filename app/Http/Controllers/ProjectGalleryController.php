<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectGalleryController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'images'   => 'required|array|max:10',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:4096|dimensions:min_width=800',
            'captions' => 'nullable|array',
            'captions.*' => 'nullable|string|max:255',
        ]);

        $currentImageCount = $project->images()->count();
        $newImageCount = count($request->file('images'));

        if ($currentImageCount + $newImageCount > 10) {
            return back()->withErrors(['images' => 'Total gambar galeri untuk project ini melebihi batas maksimal 10 gambar.']);
        }

        foreach ($request->file('images') as $index => $file) {
            $path = $file->store('projects/gallery', 'public');

            $caption = $request->captions[$index] ?? null;

            $project->images()->create([
                'image'      => $path,
                'caption'    => $caption,
                'sort_order' => $currentImageCount + $index + 1,
            ]);
        }

        return back()->with('success', 'Gambar galeri berhasil ditambahkan.');
    }

    public function updateCaption(Request $request, Project $project, ProjectImage $image)
    {
        abort_if($image->project_id !== $project->id, 404);

        $request->validate([
            'caption' => 'nullable|string|max:255',
        ]);

        $image->update([
            'caption' => $request->caption,
        ]);

        return back()->with('success', 'Caption gambar berhasil diperbarui.');
    }

    public function destroy(Project $project, ProjectImage $image)
    {
        abort_if($image->project_id !== $project->id, 404);

        if ($image->image) {
            Storage::disk('public')->delete($image->image);
        }

        $image->delete();

        return back()->with('success', 'Gambar galeri berhasil dihapus.');
    }
}