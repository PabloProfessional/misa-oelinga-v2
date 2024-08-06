<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

//    public function budget_status()
//    {
//        return $this->hasMany(ProjectActivityType::class,'act')
//    }

}
