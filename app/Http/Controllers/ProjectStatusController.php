<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectStatusRequest;
use App\Http\Requests\UpdateProjectStatusRequest;
use App\Models\ProjectStatus;

class ProjectStatusController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectStatusRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectStatus $projectStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectStatus $projectStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectStatusRequest $request, ProjectStatus $projectStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectStatus $projectStatus)
    {
        //
    }
}
