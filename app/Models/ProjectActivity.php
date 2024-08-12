<?php

namespace App\Models;

use App\Services\ProjectRiskService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProjectActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'project_id',
        'activity_type_id',
        'user_id',
        'manager_id',
        'stakeholder_id',
        'location',
        'stage_type_id',
        'status_type_id',
        'budget',
        'spend',
        'description',
        'url',
        'color',
        'start_date',
        'end_date',
        'team_members',
        'attachments',
        'notes',
        'priority_id',
        'tags',
    ];

    public function activity_type(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProjectActivityType::class,'activity_type_id');
    }

    public function status_type(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(StatusType::class,'status_type_id');
    }

    public function project(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class,'project_id');
    }

    public function progress(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProjectActivityProgress::class);
    }

    public function spend_trend_analysis(): array
    {
        // Use the relationship to get the projects activity progress and group by month
        $activity_progress_array = $this->progress()
            ->selectRaw('SUM(spend) as total_spend, to_char(created_at, \'YYYY-MM\') as month')
            ->groupBy(DB::raw('to_char(created_at, \'YYYY-MM\')'))
            ->get();

        // Initialize the spend array
        $spendArray = [];

        // Iterate through the activity_progress_array and format the month and budget
        foreach ($activity_progress_array as $project) {
            $month = Carbon::createFromFormat('Y-m', $project->month)->format('F');
            $spendArray[$month] = $project->total_spend;
        }
        return $spendArray;
    }

    public function progress_spend_by_month(): array
    {
        // Fetch progress data grouped by month and calculate the total spend for each month
        $progress_by_month = $this->progress()
            ->selectRaw('SUM(spend) as total_spend, to_char(created_at, \'YYYY-MM\') as month')
            ->groupBy(DB::raw('to_char(created_at, \'YYYY-MM\')'))
            ->get();

        // Initialize the result array
        $spend_by_month = [];

        // Iterate over the results and format them into month => total_spend array
        foreach ($progress_by_month as $progress) {
            $month_name = Carbon::createFromFormat('Y-m', $progress->month)->format('F');
            $spend_by_month[$month_name] = $progress->total_spend;
        }

        return $spend_by_month;
    }

    public function risk_status(): int
    {
        $calculateRisk = new ProjectRiskService(null, ProjectActivity::find($this->id));
        return $calculateRisk->calculateRisk();
    }

}
