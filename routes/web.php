<?php

use App\Http\Controllers\ProfileController;
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

Route::get('/projects/spend', function () {
    return response()->json(['spend' => number_format((Project::sum('spend')/1000000),2) ]);
});

Route::get('/projects/variance', function () {
    $budget = Project::sum('budget');
    $spend = Project::sum('spend');

    if ($budget != 0) {
        $variance = 100 - (($budget - $spend )/$budget);
        return response()->json(['variance' => number_format($variance,0) ]);
    }
    return response()->json(['variance' => number_format(0,0) ]);
});

Route::get('/provinces/summary', function () {
    return response()->json(['provinces' => \App\Models\Province::all()]);
});

Route::get('/provinces/trend_analysis', [\App\Http\Controllers\ProvinceController::class,'trend_analysis'])
    ->middleware(['auth', 'verified'])
    ->name('province_trend_analysis');

Route::resource('project',\App\Http\Controllers\ProjectController::class)->middleware(['auth', 'verified']);

Route::get('/municipalities/by_province/{provinceId}', function ($provinceId) {
    return response()->json(['municipalities' => \App\Models\Municipality::where('province_id', $provinceId)
        ->select('id','name')
        ->get()]);
});

require __DIR__.'/auth.php';
