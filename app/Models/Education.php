<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'educations';

    protected $fillable = [
        'degree',
        'school',
        'location',
        'start_date',
        'end_date',
        'is_present',
        'summary',
        'sort_order',
    ];

    protected $casts = [
        'is_present' => 'boolean',
    ];
}
