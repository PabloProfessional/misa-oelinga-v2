<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProvinceRequest;
use App\Http\Requests\UpdateProvinceRequest;
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
    public function show(Province $province)
    {
        //

        dd($province);
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
}
