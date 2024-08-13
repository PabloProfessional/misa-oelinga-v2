<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Province extends Model
{
    use HasFactory, UuidTrait;

    protected $casts = [
        'url' => 'string',
    ];

    public function getKeyName(): string
    {
        return 'url';
    }

    public function projects(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function budget(): float
    {
        return $this->projects()->sum('budget');
    }

    public function spend(): float
    {
        return $this->projects()->sum('spend');
    }

    public function status()
    {
        // Extract status_ids from projects
        $statusIds = [];

        foreach ($this->projects as $project) {
            foreach ($project->average_project_status as $status) {
                $statusIds []= $status->status_type_id;
            }
        }

        //dd(gettype($statusIds));

        if ($statusIds) {
            // Count occurrences of each status_id
            $statusIdCounts = array_count_values($statusIds);

            // Find the status_id with the maximum count
            $mostCommonStatusId = array_search(max($statusIdCounts), $statusIdCounts);

            return StatusType::find($mostCommonStatusId);
        } else {

            return null;
        }

    }

    public function budget_variance(): int
    {
        $spend = $this->projects()->sum('spend');
        $budget = $this->projects()->sum('budget');

        $variance = 0;

        if ($budget != 0) {
            $variance = (($budget - $spend) / $budget) * 100;
        }

        return $variance;

    }

    public function projectStatus(): \Illuminate\Database\Eloquent\Collection
    {
        return $this->projects()->select('status_id', DB::raw('COUNT(*) as count'))
            ->groupBy('status_id')
            ->get();
    }

    public function municipalities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Municipality::class,'province_id','id');
    }

    public function budget_trend_analysis(): array
    {
        // Use the relationship to get the projects and group by month
        $projects = $this->projects()
            ->selectRaw('SUM(budget) as total_budget, to_char(start_date, \'YYYY-MM\') as month')
            ->groupBy(DB::raw('to_char(start_date, \'YYYY-MM\')'))
            ->get();

        // Initialize the budget array
        $budgetArray = [];

        // Iterate through the projects and format the month and budget
        foreach ($projects as $project) {
            $month = Carbon::createFromFormat('Y-m', $project->month)->format('F');
            $budgetArray[$month] = $project->total_budget / 100;
        }

        return $budgetArray;
    }

    public function spend_trend_analysis(): array
    {
        // Use the relationship to get the projects and group by month
        $projects = $this->projects()
            ->selectRaw('SUM(spend) as total_budget, to_char(start_date, \'YYYY-MM\') as month')
            ->groupBy(DB::raw('to_char(start_date, \'YYYY-MM\')'))
            ->get();

        // Initialize the budget array
        $budgetArray = [];

        // Iterate through the projects and format the month and budget
        foreach ($projects as $project) {
            $month = Carbon::createFromFormat('Y-m', $project->month)->format('F');
            $budgetArray[$month] = $project->total_budget / 100;
        }

        return $budgetArray;
    }

    public function activity_total(): float|int
    {
        $total_budgets_in_project_activities = 0;

        foreach ($this->projects as $project) {
            if ($project->project_activity != null) {
                foreach ($project->project_activity as $activity) {
                    $total_budgets_in_project_activities += $activity->budget ;
                }
            }
        }

        return $total_budgets_in_project_activities;
    }
}
