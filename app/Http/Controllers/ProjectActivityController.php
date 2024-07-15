<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectActivityRequest;
use App\Http\Requests\UpdateProjectActivityRequest;
use App\Models\Project;
use App\Models\ProjectActivity;
use Inertia\Inertia;

class ProjectActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($project_url)
    {
        //

        $project = Project::where('url',$project_url)->first();

        return Inertia::render('ProjectActivity/Create',[
            'project' => $project
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectActivityRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectActivity $projectActivity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectActivity $projectActivity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectActivityRequest $request, ProjectActivity $projectActivity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectActivity $projectActivity)
    {
        //
    }
}
