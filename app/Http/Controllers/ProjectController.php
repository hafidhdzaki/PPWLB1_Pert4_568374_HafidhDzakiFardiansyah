<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = array(
            'id' => 'projects',
            'projects' => Project::published()->get()
        );
        return view('projects.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request -> validate ([
            'title' => 'required|string|min:5',
            'tools'=> 'required|string',
            'description' => 'required|string|min:10',
            'status' => 'required|in:published,draft'
        ]);

        Project::create($request->only(['title', 'tools', 'description', 'status']));

        return redirect()->route('projects.index')
        -> with ('success', 'Project telah berhasil ditambahkan.');
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data = array(
            'id' => 'projects',
            'projects' => Project::find($id)
        );
        return view('projects.show')->with($data);
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $project = Project::findOrFail($id);
        $data = [
            'project' => $project,
        ];
        return view('projects.edit', $data);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request -> validate ([
            'title' => 'required|string|min:5',
            'tools' => 'required|string',
            'description' => 'required|string|min:10',
            'status' => 'required|in:published,draft'
        ]);

        $project = Project::findOrFail($id);
        $project->update($validatedData);

        return redirect()->route('projects.index') -> with ('success', 'Project berhasil diperbarui.');
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project berhasil dihapus.');
        //
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
        $project->forceDelete();
        return redirect()->route('projects.trash')->with('success', 'Project berhasil dihapus permanen');
    }
}
