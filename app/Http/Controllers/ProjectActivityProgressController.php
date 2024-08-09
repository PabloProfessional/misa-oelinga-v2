<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectActivityProgressRequest;
use App\Http\Requests\UpdateProjectActivityProgressRequest;
use App\Models\ProjectAccount;
use App\Models\ProjectActivity;
use App\Models\ProjectActivityProgress;
use App\Models\Province;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ProjectActivityProgressController extends Controller
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
    public function store(StoreProjectActivityProgressRequest $request)
    {
        // dd($request->all());

        $request->validate([
            'spend' => 'nullable|string',
            'percentage_completion' => 'required|string',
            'attachment' => 'nullable|file',
            'notes' => 'nullable|string',
        ]);

        $spend = (int) str_replace('R ','',str_replace(',','',$request->spend)) * 100;
        $percentage_completion = str_replace('%','',$request->percentage_completion);

        $attachment = $request->file('attachment');
        $attachmentName = 'project_activity_progress_attachment_' . $request->project_number . '_' . time() . '.' . $attachment->getClientOriginalExtension();
        $attachmentPath = Storage::disk('public')->putFileAs('project_activity/attachments', $attachment, $attachmentName);

        //dd($attachmentPath);

        $projectActivityProgress = ProjectActivityProgress::create([
            'project_activity_id' => $request->project_activity_id,
            'spend' => $spend,
            'percentage_completion' => $percentage_completion,
            'file' => $attachmentPath ?? null,
            'is_approved' => true,
            'user_id' => auth()->user()->id,
            'custom_1',
            'custom_2',
            'notes' => $request->notes,
        ]);

        $project_activity = ProjectActivity::find($request->project_activity_id);
        $project_activity->spend += $spend;
        $project_activity->save();


        ProjectAccount::create([
            'project_id' => $project_activity->project->id,
            'credit' => 0,
            'debit' => $spend,
            'description' => 'Project Activity Update | '.$project_activity->name,
            'balance' => $project_activity->project->accounts->first()->balance - $spend
        ]);

        return Redirect::back();
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectActivityProgress $projectActivityProgress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProjectActivityProgress $projectActivityProgress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectActivityProgressRequest $request, ProjectActivityProgress $projectActivityProgress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectActivityProgress $projectActivityProgress)
    {
        //
    }


    public function trend_analysis($project_activity_progress): array
    {
        $allMonths = collect([
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ]);
        // Collection of all provinces
        $allProvinces = collect($project_activity_progress);
        // Initialize arrays for combined budget and spend data
        $combinedBudgetData = array_fill_keys($allMonths->all(), 0);
        $combinedSpendData = array_fill_keys($allMonths->all(), 0);
        $allProvinces->each(function ($province) use ($allMonths, &$combinedBudgetData, &$combinedSpendData) {
            // Fill budget data
            $budgetDataStart = collect($province->budget_trend_analysis());
            $budgetByMonth = $allMonths->mapWithKeys(function ($month) use ($budgetDataStart) {
                return [$month => $budgetDataStart->get($month, 0)];
            });

            // Sum budget data
            foreach ($budgetByMonth as $month => $value) {
                $combinedBudgetData[$month] += $value;
            }

            // Fill spend data
            $spendDataStart = collect($province->spend_trend_analysis());
            $spendByMonth = $allMonths->mapWithKeys(function ($month) use ($spendDataStart) {
                return [$month => $spendDataStart->get($month, 0)];
            });

            // Sum spend data
            foreach ($spendByMonth as $month => $value) {
                $combinedSpendData[$month] += $value;
            }
        });

        return [
//            'months' => $allMonths,
            'budget' => array_values($combinedBudgetData),
            'spend' => array_values($combinedSpendData)
        ];
    }
}
