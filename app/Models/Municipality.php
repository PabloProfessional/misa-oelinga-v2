<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Municipality extends Model
{
    use HasFactory, UuidTrait;

    protected $fillable = ['name','url','logo','province_id'];

    public function province(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Province::class,'province_id');
    }

    public function projects(): \Illuminate\Database\Eloquent\Relations\HasMany
    {

        return $this->hasMany(Project::class,'municipal_id');
    }

    public function budget_and_spend(): array
    {
        $output = [
            'budget' => 0,
            'spend' => 0,
        ];

        foreach ($this->projects as $project) {
            $output['budget'] =+ $project->budget;
            $output['spend'] =+ $project->spend;
        }

        return $output;
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

            return StatusType::find($mostCommonStatusId)->first()->toArray();
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
            $budgetArray[$month] = $project->total_budget;
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
            $budgetArray[$month] = $project->total_budget;
        }

        return $budgetArray;
    }

    public function budgetByMonth(): \Illuminate\Support\Collection
    {
        $allMonths = collect([
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ]);

        // Fill budget data
        $budgetDataStart = collect($this->budget_trend_analysis());
        return $allMonths->mapWithKeys(function ($month) use ($budgetDataStart) {
            return [$month => $budgetDataStart->get($month, 0)];
        });

    }

    public function spendByMonth(): \Illuminate\Support\Collection
    {
        $allMonths = collect([
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ]);

        // Fill spend data
        $spendDataStart = collect($this->spend_trend_analysis());
        return $allMonths->mapWithKeys(function ($month) use ($spendDataStart) {
            return [$month => $spendDataStart->get($month, 0)];
        });

    }

    public function topProjects(): array
    {
        $top_projects = $this->projects()->select('project_number','budget','spend')
            ->orderBy('budget','asc')
            ->limit(6)->get();

        return array_pad($top_projects->toArray(), 6, [
            'project_number' => 'None Yet',
            'budget' => 0,
            'spend' => 0
        ]);

    }

    public function statusCounts(): \Illuminate\Support\Collection
    {
        // Get the statuses
        $statuses = collect($this->projects)->map(function ($project) {
            return $project->status()->name;
        });

        // Count the occurrences of each status name
        return $statuses->countBy();
    }
}
