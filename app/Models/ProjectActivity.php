<?php

namespace App\Models;

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

        // Add the spend on the date the activity was created. No need.

//        $createdMonth = Carbon::createFromFormat('Y-m', date_format($this->created_at,'Y-m'))->format('F');
//
//        $spendArray[$createdMonth] += $this->spend;

        return $spendArray;

    }



}
