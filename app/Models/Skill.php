<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Skill extends Model
{
    protected $fillable = [
        'skill_category_id',
        'name',
        'icon',
        'level',
        'years',
        'note',
        'sort_order',
    ];

    protected $casts = [
        'level' => 'integer',
        'years' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(SkillCategory::class, 'skill_category_id');
    }
}
