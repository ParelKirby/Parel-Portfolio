<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'title',
        'company',
        'location',
        'start_date',
        'end_date',
        'is_present',
        'summary',
        'bullets',
        'tech',
        'link',
        'sort_order',
    ];

    protected $casts = [
        'bullets' => 'array',
        'tech' => 'array',
        'is_present' => 'boolean',
    ];

    public function toPortfolioArray(): array
    {
        return [
            'id' => (string) $this->id,
            'title' => $this->title,
            'company' => $this->company,
            'location' => $this->location,
            'date' => [
                'start' => $this->start_date,
                'end' => $this->end_date,
                'present' => (bool) $this->is_present,
            ],
            'summary' => $this->summary,
            'bullets' => $this->bullets ?? [],
            'tech' => $this->tech ?? [],
            'link' => $this->link,
        ];
    }
}
