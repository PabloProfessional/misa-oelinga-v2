<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectActivityRequest;
use App\Http\Requests\UpdateProjectActivityRequest;
use App\Models\Project;
use App\Models\ProjectAccount;
use App\Models\ProjectActivity;
use App\Models\ProjectActivityType;
use App\Models\ProjectStageType;
use App\Models\Province;
use App\Models\StatusType;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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

        $project = Project::where('url',$project_url)->first()->toArray();

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

        // Initialize an array to store file paths
        $filePaths = [];

        // Check if the attachment file is present and store it with a custom name
        if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment');
            $attachmentName = 'project_activity_attachment_' . $request->project_number . '_' . time() . '.' . $attachment->getClientOriginalExtension();
            $attachmentPath = Storage::disk('public')->putFileAs('project_activity/attachments', $attachment, $attachmentName);
            $filePaths['attachment'] = $attachmentPath;
        }

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
            'attachments' => json_encode(
                [
                    'project_activity_attachment' => $filePaths['attachment']
                ]
            ),
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

        $trend_analysis = $this->trend_analysis($projectActivity);

        return Inertia::render('ProjectActivity/Show',[
            'activity' => $projectActivity,
            'activity_type' => $projectActivity->activity_type,
            'project' => $projectActivity->project,
            'province' => $projectActivity->project->province,
            'municipality' => $projectActivity->project->municipality,
            'programme' => $projectActivity->project->programme,
            'status' => $projectActivity->project->status(),
            'project_stage' => $projectActivity->project->stage,
            'project_activities' => $projectActivity->project->project_activity,
            'progress' => $projectActivity->progress->last(),
            'budget_trend' => array_values($trend_analysis['budget']),
            'spend_trend' => array_values($trend_analysis['spend']),
        ]);
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

    public function trend_analysis($project_activity): array
    {
        $allMonths = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        // Initialize arrays for combined spend data
        $combinedSpendData = array_fill_keys($allMonths, 0);
        $budgetData = array_fill_keys($allMonths, 0);

        // Fill spend data
        $spendDataStart = collect($project_activity->spend_trend_analysis());
        $spendByMonth = collect($allMonths)->mapWithKeys(function ($month) use ($spendDataStart) {
            return [$month => $spendDataStart->get($month, 0)];
        });

        // Sum spend data and fill budget data
        foreach ($spendByMonth as $month => $value) {
            $combinedSpendData[$month] += $value / 100;
            if ($value > 0) {
                $budgetData[$month] = $project_activity->budget / 100;
            }
        }

        return [
            'spend' => $combinedSpendData,
            'budget' => $budgetData
        ];
    }


    public function trend_analysis_working($project_activity): array
    {
        $allMonths = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        // Initialize arrays for combined spend data
        $combinedSpendData = array_fill_keys($allMonths, 0);

        // Fill spend data
        $spendDataStart = collect($project_activity->spend_trend_analysis());
        $spendByMonth = collect($allMonths)->mapWithKeys(function ($month) use ($spendDataStart) {
            return [$month => $spendDataStart->get($month, 0)];
        });

        // Sum spend data
        foreach ($spendByMonth as $month => $value) {
            $combinedSpendData[$month] += $value;
        }

        return [
            'spend' => $combinedSpendData
        ];
    }
}
