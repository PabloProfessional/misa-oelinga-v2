<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProvinceRequest;
use App\Http\Requests\UpdateProvinceRequest;
use App\Models\Project;
use App\Models\Province;
use Inertia\Inertia;
use Inertia\Response;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        //

        $budget = $this->trend_analysis()['budget'];
        $spend = $this->trend_analysis()['spend'];

        return Inertia::render('Dashboard',[
            'budget' => $budget,
            'spend' => $spend
        ]);

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
    public function store(StoreProvinceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Province $province): Response
    {
        //dd($province);

        // Get the statuses
        $statuses = collect($province->projects)->map(function ($project) {
            return $project->status()->name;
        });

        // Count the occurrences of each status name
        $statusCounts = $statuses->countBy();

        // dd(array_keys(array_values((array)$statusCounts)[0]));

        $budget = $province->budget() / 100000000;
        $spend = $province->spend() / 100000000;
        $variance = 0;
        if ($budget != 0) {
            $variance = ($spend / $budget) * 100;
        }

        $trend_analysis = $this->province_trend_analysis($province);

        $tops = $this->top_projects($province);
        $top_budgets = array_map(function($tops) {
            return $tops['budget'];
        }, $tops);
        $top_spends= array_map(function($tops) {
            return $tops['spend'];
        }, $tops);

        $municipalities = [];

        foreach ($province->municipalities as $municipality) {
            $budget_and_spend = $municipality->budget_and_spend();
            //dd($municipality->status());
            $municipalities []= [
                'name' => $municipality->name,
                'url' => $municipality->url,
                'budget' => number_format($budget_and_spend['budget']/100,2),
                'spend' => number_format($budget_and_spend['spend']/100,2),
                'average_status_name' => $municipality->status()['name'] ?? null,
                'average_status_color' => $municipality->status()['color'] ?? null,
            ];
        }

        $projects = [];

        foreach ($province->projects as $project) {
            $projects []= [
                'name' => $project->name,
                'budget' => number_format($project->budget/100,2),
                'spend' => number_format($project->spend/100,2),
                'url' => $project->url,
                'average_status_name' => $project->status()['name'] ?? null,
                'average_status_color' => $project->status()['color'] ?? null,
            ];
        }

        // dd($municipalities);

        return Inertia::render('Province/Show',[
            'province' => $province,
            'count' => $province->projects->count(),
            'budget' => $budget,
            'spend' => $spend,
            'budget_allocation' => 0,
            'variance' => $variance,
            'budget_trend' => array_values($trend_analysis['budget']),
            'spend_trend' => array_values($trend_analysis['spend']),
            'status_count_values' => array_values(array_values((array)$statusCounts)[0]),
            'status_count_keys' => array_keys(array_values((array)$statusCounts)[0]),
            'top_projects' => $tops,
            'top_budgets' => $top_budgets,
            'top_spends' => $top_spends,
            'municipalities' => $municipalities,
            'projects' => $projects
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Province $province)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProvinceRequest $request, Province $province)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Province $province)
    {
        //
    }

    public function trend_analysis(): array
    {
        $allMonths = collect([
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ]);
        // Collection of all provinces
        $allProvinces = collect(Province::all());
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

    public function getStatus($id): \Illuminate\Http\JsonResponse
    {
        $province = Province::find($id);
        if ($province) {
            return response()->json(['province_status' => $province->id]);
        } else {
            return response()->json(['province_status' => null], 404);
        }
    }

    public function province_trend_analysis($province): array
    {
        $allMonths = collect([
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ]);


        // Fill budget data
        $budgetDataStart = collect($province->budget_trend_analysis());
        $budgetByMonth = $allMonths->mapWithKeys(function ($month) use ($budgetDataStart) {
            return [$month => $budgetDataStart->get($month, 0)];
        })->toArray();

        // Fill spend data
        $spendDataStart = collect($province->spend_trend_analysis());
        $spendByMonth = $allMonths->mapWithKeys(function ($month) use ($spendDataStart) {
            return [$month => $spendDataStart->get($month, 0)];
        })->toArray();

        return [
            'budget' => $budgetByMonth,
            'spend' => $spendByMonth
        ];
    }

    public function top_projects($province): array
    {
        $top_projects = Project::where('province_url',$province->url)->select('project_number','budget','spend')
            ->orderBy('budget','asc')
            ->limit(6)->get();
        // If fewer than 6 projects, fill the rest with placeholders

        return array_pad($top_projects->toArray(), 6, [
            'project_number' => 'None Yet',
            'budget' => 0,
            'spend' => 0
        ]);
    }
}
