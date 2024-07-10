<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Department;
use App\Models\Programme;
use App\Models\Project;
use App\Models\ProjectStageType;
use App\Models\Province;
use App\Models\Sector;
use App\Models\StatusType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
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
    public function create(Request $request): Response
    {
        //dd(Programme::select('id','name')->get()->toArray());

        return Inertia::render('Project/Create',[
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
            'programmes' => Programme::select('id','name')->get(),
            'provinces' => Province::select('id','name')->get(),
            'departments' => Department::select('id','name')->get(),
            'sectors' => Sector::select('id','name')->get(),
            'project_stage_types' => ProjectStageType::select('id','name')->get(),
            'status_procurement' => StatusType::where('category','Procurement')->select('id','name')->get(),
            'status_budget' => StatusType::where('category','Budget')->select('id','name')->get(),
            'status_risk' => StatusType::where('category','Risk')->select('id','name')->get(),
            'status_schedule' => StatusType::where('category','Schedule')->select('id','name')->get(),
            'users' => User::select('id','name')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        //
        dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
