<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Project extends Model
{
    use HasFactory, UuidTrait;


    protected $fillable = [
        'uuid',
        'name',
        'user_id',
        'url',
        'procurement_status_id',
        'project_number',
        'programme_id',
        'department_id',
        'sector_id',
        'province_url',
        'municipal_id',
        'manager',
        'description',
        'logo',
        'data',
        'status_id',
        'start_date',
        'end_date',
        'budget',
        'spend',
        'priority_id',
        'tags',
        'client_id',
        'team_members',
        'attachments',
        'location',
        'notes',
        'stage_type_id'
    ];

    public function programme(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Programme::class,'programme_id');
    }

    public function sector(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Sector::class,'sector_id');
    }

    public function stage(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ProjectStageType::class,'stage_type_id');
    }

    public function municipality(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Municipality::class,'municipal_id');
    }


    public function province(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Province::class,'province_url');
    }

    public function average_project_status(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProjectStatus::class,'project_id')->orderBy('id','desc');
    }

    public function status()
    {
        // Extract status_ids from projects
        $statusIds = [];

        foreach ($this->average_project_status as $status) {
            $statusIds []= $status->status_type_id;
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
        $spend = $this->spend;
        $budget = $this->budget;
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

    public function project_accounts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProjectAccount::class,'project_id')->orderBy('id','desc');
    }

    public function project_activity(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProjectActivity::class,'project_id');
    }

    public function spend_trend_analysis(): array
    {
        $activity_spend_array = $this->project_activity()
            ->selectRaw('SUM(spend) as total_spend, to_char(created_at, \'YYYY-MM\') as month')
            ->groupBy(DB::raw('to_char(created_at, \'YYYY-MM\')'))
            ->get();

        // Initialize the spend array
        $spendArray = [];

        // Iterate through the activity_progress_array and format the month and budget
        foreach ($activity_spend_array as $project) {
            $month = Carbon::createFromFormat('Y-m', $project->month)->format('F');
            $spendArray[$month] = $project->total_spend;
        }

        // Add the spend on the date the project was created.

        $createdMonth = Carbon::createFromFormat('Y-m', date_format($this->created_at,'Y-m'))->format('F');
        $spendArray[$createdMonth] = $this->spend;

        return $spendArray;
    }


}
