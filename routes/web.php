<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProvinceController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Models\Project;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/projects/count', function () {
    return response()->json(['count' => Project::count()]);
});

Route::get('/projects/budget', function () {
    return response()->json(['budget' => number_format((Project::sum('budget')/1000000),2) ]);
});

Route::get('/projects/budget_allocation', function () {
    return response()->json(['budget_allocation' => number_format((Project::sum('spend') / Project::sum('budget')) * 100,1) ]);
});

Route::get('/projects/spend', function () {
    return response()->json(['spend' => number_format((Project::sum('spend')/1000000),2) ]);
});

Route::get('/projects/variance', function () {
    $budget = Project::sum('budget');
    $spend = Project::sum('spend');

    // TODO Will need to add projectActivity budget to this as well. Or we do ProjectActivities only.
    // Since there is spend and allocation those are different.

    if ($budget != 0) {
        $variance = (($budget - $spend )/$budget) * 100;
        return response()->json(['variance' => number_format($variance,0) ]);
    }
    return response()->json(['variance' => number_format(0,0) ]);
});

//Route::get('/provinces/summary', function () {
//    return response()->json(['provinces' => \App\Models\Province::all()]);
//});

Route::get('/provinces/summary', function () {
    $provinces = \App\Models\Province::all()->map(function ($province) {
        return array_merge($province->toArray(), ['status' => $province->status()]);
    });

    return response()->json(['provinces' => $provinces]);
});

Route::get('/provinces/trend_analysis', [\App\Http\Controllers\ProvinceController::class,'trend_analysis'])
    ->middleware(['auth', 'verified'])
    ->name('province_trend_analysis');

Route::resource('project',\App\Http\Controllers\ProjectController::class)->middleware(['auth', 'verified']);

Route::get('/municipalities/by_province/{provinceId}', function ($provinceId) {
    return response()->json(['municipalities' => \App\Models\Municipality::where('province_id', $provinceId)
        ->select('id','name','province_id')
        ->get()]);
});

Route::get('/province/status/{id}', [ProvinceController::class, 'getStatus']);


require __DIR__.'/auth.php';
