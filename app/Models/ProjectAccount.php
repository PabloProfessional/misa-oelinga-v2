<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectAccount extends Model
{
    use HasFactory, UuidTrait;

    protected $fillable = [
        'project_id',
        'debit',
        'credit',
        'balance',
        'description',
        'custom_1',
        'custom_2',
        'custom_3',
    ];
}
