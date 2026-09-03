<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'name',
        'title',
        'headline',
        'summary',
        'hero_summary',
        'email',
        'phone',
        'location',
        'avatar_path',
        'avatar_label',
    ];

    protected $casts = [
        'hero_summary' => 'string',
    ];
}
