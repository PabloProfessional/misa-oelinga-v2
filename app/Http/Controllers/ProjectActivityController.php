<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectActivityRequest;
use App\Http\Requests\UpdateProjectActivityRequest;
use App\Models\Project;
use App\Models\ProjectAccount;
use App\Models\ProjectActivity;
use App\Models\ProjectActivityType;
use App\Models\ProjectStageType;
use App\Models\StatusType;
use App\Models\User;
use Illuminate\Support\Str;
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
            'project' => $project,
            'project_stage_types' => ProjectStageType::select('id','name')->get(),
            'status_procurement' => StatusType::where('category','Procurement')->select('id','name')->get(),
            'status_budget' => StatusType::where('category','Budget')->select('id','name')->get(),
            'status_risk' => StatusType::where('category','Risk')->select('id','name')->get(),
            'status_schedule' => StatusType::where('category','Schedule')->select('id','name')->get(),
            'users' => User::select('id','name')->get(),
            'project_activity_types' => ProjectActivityType::select('id','name')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectActivityRequest $request)
    {
        //dd($request->all());

        $project = Project::where('url',$request->project_url)->first();


        $request->validate([
            'name' => 'required|string|max:255',
            'project_activity_type' => 'required|numeric',
            'description' => 'nullable|string',
            //'location' => 'required|numeric',
            'project_stage' => 'required|numeric',
            'budget' => 'nullable|string',
            'spend' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'manager' => 'required|numeric',
            //'priority_id' => 'required|numeric',
            'attachments.*' => 'nullable|file',
            'notes' => 'nullable|string',
        ]);

        $statuses = [$request->procurement_status,$request->budget_status,$request->schedule_status,$request->risk_status];
        $status = array_sum($statuses) / count($statuses);
        $budget = (int) str_replace('R ','',str_replace(',','',$request->budget)) * 100;
        $spend = (int) str_replace('R ','',str_replace(',','',$request->spend)) * 100;

        $projectActivity = ProjectActivity::create([
            'project_id' => $project->id,
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'activity_type_id' => $request->project_activity_type,
            'description' => $request->description,
            'location' => $project->municipal_id,
            'budget' => $budget,
            'spend' => $spend,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'manager_id' => $request->manager,
            'priority_id' => 1,
            'team_members' => json_encode($request->team_members),
            'attachments' => json_encode($request->attachments),
            'notes' => $request->note,
            'stakeholder_id' => $request->manager,
            'stage_type_id' =>  $request->project_stage,
            'status_type_id' => (int)$status,
            'url' => Str::slug($request->name).time(),
            'color' => sprintf("#%02x%02x%02x", rand(0, 255), rand(0, 255), rand(0, 255))
        ]);

        $project->spend += $projectActivity->spend;
        $project->save();

        ProjectAccount::create([
            'project_id' => $project->id,
            'credit' => 0,
            'debit' => $spend,
            'description' => $projectActivity->name.' - '.$projectActivity->description,
            'balance' => $project->project_accounts->first()->balance - $spend
        ]);

        return redirect('/project/'.$project->url)->with('status','Project Activity: '.$projectActivity->name.' added to project');


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
