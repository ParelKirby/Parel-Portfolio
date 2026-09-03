<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    protected $fillable = [
        'name',
        'issuer',
        'url',
        'start_date',
        'end_date',
        'is_present',
        'description',
        'sort_order',
    ];

    protected $casts = [
        'is_present' => 'boolean',
    ];
}
