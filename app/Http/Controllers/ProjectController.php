<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Department;
use App\Models\Municipality;
use App\Models\Programme;
use App\Models\Project;
use App\Models\ProjectAccount;
use App\Models\ProjectStageType;
use App\Models\Province;
use App\Models\Sector;
use App\Models\StatusType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\ProjectStatus;

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
        //dd($request->all());

        $request->validate([
            'project_number' => 'required|string|unique:projects',
            'programme' => 'required|numeric',
            'name' => 'required|string|unique:projects',
            'description' => 'nullable|string',
            'province' => 'required|numeric',
            'municipality' => 'required|numeric',
            'department' => 'required|numeric',
            'sector' => 'required|numeric',
            'budget' => 'required|string', // Maximum budget of 100 billion
            'spend' => 'required|string', // Maximum spend of 100 billion
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'procurement_status' => 'required|numeric',
            'budget_status' => 'required|numeric',
            'schedule_status' => 'required|numeric',
            'risk_status' => 'required|numeric',
            'manager' => 'nullable|numeric',
            'logo' => 'nullable|image|max:2048', // Assuming logo is an image file, maximum 2MB
            'priority_id' => 'numeric',
            'team_members' => 'nullable|array', // Assuming team_members is an array
            'team_members.*' => 'numeric', // Assuming team_members is an array of numeric values
            'attachments' => 'nullable|array', // Assuming attachments is an array
            'attachments.*' => 'nullable|file|max:2048', // Assuming attachments is an array of file uploads, maximum 2MB each
            'notes' => 'nullable|string',
            'project_stage' => 'required|numeric',
        ]);

        $budget = (int) str_replace('R ','',str_replace(',','',$request->budget)) * 100;
        $spend = (int) str_replace('R ','',str_replace(',','',$request->spend)) * 100;

        //dd($budget);


        $project = Project::create([
            'project_number' => $request->project_number,
            'programme_id' => $request->programme,
            'name' => $request->name,
            'user_id' => auth()->user()->id,
            'description' => $request->description,
            'url' => Str::slug($request->name),
            'municipal_id' => $request->municipality,
            'department_id' => $request->department,
            'sector_id' => $request->sector,
            'budget' => $budget,
            'spend' => $spend,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'manager' => $request->manager,
            'province_url' => Province::where('id',$request->province)->first()->url,
            'stage_type_id' => $request->project_stage,
            'notes' => $request->notes,
            'client_id' => $request->client_id,
            'team_members' => json_encode($request->team_members),
            'attachments' => json_encode($request->attachments),
            'procurement_status_id' => $request->procurement_status,
            'logo' => $request->logo,
            'status_id' => $request->status_id,
            'priority_id' => $request->priority_id,
        ]);
        //dd($request->procurement_status);

        ProjectStatus::create([
            'project_id' => $project->id,
            'status_type_id' => $request->procurement_status,
            'project_aspect' => 'Procurement'
        ]);

        ProjectStatus::create([
            'project_id' => $project->id,
            'status_type_id' => $request->budget_status,
            'project_aspect' => 'Budget'
        ]);

        ProjectStatus::create([
            'project_id' => $project->id,
            'status_type_id' => $request->schedule_status,
            'project_aspect' => 'Schedule'
        ]);

        ProjectStatus::create([
            'project_id' => $project->id,
            'status_type_id' => $request->risk_status,
            'project_aspect' => 'Risk'
        ]);

        ProjectAccount::create([
            'project_id' => $project->id,
            'credit' => $project->budget,
            'debit' => $project->spend,
            'description' => 'Opening balance',
            'balance' => $project->budget - $project->spend
        ]);

        //return redirect('project/'.$project->url)->with('status',$project->name.' - has been created');

        return redirect('/dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show($url): Response
    {
        //dd($url);

        $project = Project::where('url', $url)->first();

        // Get the activity types
        $activityTypes = $project->project_activity->map(function ($activity) {
            return $activity->activity_type->name;
        });


        // Count the occurrences of each status name
        $activityCounts = $activityTypes->countBy();

        //dd($project->stage);

        $status_procurement = [
            $project->average_project_status->where('project_aspect','Procurement')->first()->status_type->name,
            $project->average_project_status->where('project_aspect','Procurement')->first()->status_type->icon,
            $project->average_project_status->where('project_aspect','Procurement')->first()->status_type->color
        ];

        $status_risk = [
            $project->average_project_status->where('project_aspect','Risk')->first()->status_type->name,
            $project->average_project_status->where('project_aspect','Risk')->first()->status_type->icon,
            $project->average_project_status->where('project_aspect','Risk')->first()->status_type->color
        ];
        $status_budget = [
            $project->average_project_status->where('project_aspect','Budget')->first()->status_type->name,
            $project->average_project_status->where('project_aspect','Budget')->first()->status_type->icon,
            $project->average_project_status->where('project_aspect','Budget')->first()->status_type->color
        ];

        $status_schedule = [
            $project->average_project_status->where('project_aspect','Schedule')->first()->status_type->name,
            $project->average_project_status->where('project_aspect','Schedule')->first()->status_type->icon,
            $project->average_project_status->where('project_aspect','Schedule')->first()->status_type->color
        ];


        return Inertia::render('Project/Show',[
            'project' => $project,
            'province' => $project->province,
            'municipality' => $project->municipality,
            'programme' => $project->programme,
            'status' => $project->status(),
            'status_procurement' => $status_procurement,
            'status_risk' => $status_risk,
            'status_budget' => $status_budget,
            'status_schedule' => $status_schedule,
            'sector' => $project->sector,
            'project_stage' => $project->stage,
            'project_activities' => $project->project_activity,
        ]);
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
