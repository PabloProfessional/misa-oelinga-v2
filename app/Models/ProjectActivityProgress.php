<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProjectActivityProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_activity_id',
        'spend',
        'percentage_completion',
        'file',
        'is_approved',
        'user_id',
        'custom_1',
        'custom_2',
        'notes',
    ];


}
