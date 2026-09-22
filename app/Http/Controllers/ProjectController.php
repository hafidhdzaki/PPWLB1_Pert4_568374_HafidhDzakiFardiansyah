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
            'projects' => Project::all()
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
            'title' => 'required',
            'tools'=> 'required',
            'description' => 'required',
        ]);

        Project::create($request->only(['title', 'tools', 'description']));

        return redirect()->route('projects.index');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
