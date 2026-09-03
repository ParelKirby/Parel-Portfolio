<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'short',
        'description',
        'image',
        'href',
        'is_under_development',
        'featured',
        'tags',
        'links',
        'sort_order',
    ];

    protected $casts = [
        'tags' => 'array',
        'links' => 'array',
        'is_under_development' => 'boolean',
        'featured' => 'boolean',
    ];

    protected function apiId(): Attribute
    {
        return Attribute::get(fn () => $this->slug);
    }

    public function toPortfolioArray(): array
    {
        return [
            'id' => $this->slug,
            'title' => $this->title,
            'short' => $this->short,
            'description' => $this->description,
            'tags' => $this->tags ?? [],
            'image' => $this->image,
            'href' => $this->href,
            'links' => $this->links ?? [],
            'isUnderDevelopment' => (bool) $this->is_under_development,
            'featured' => (bool) $this->featured,
        ];
    }
}
