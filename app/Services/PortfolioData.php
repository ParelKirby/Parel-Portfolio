<?php

namespace App\Services;

use App\Models\Certification;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Highlight;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SkillCategory;
use App\Models\SocialLink;

class PortfolioData
{
    public function all(): array
    {
        $profile = Profile::orderBy('id')->first();

        return [
            'meta' => [
                'createdAt' => now()->toISOString(),
                'locale' => config('portfolio.meta.locale'),
                'pdf' => config('portfolio.meta.pdf'),
            ],
            'personal' => $this->personal($profile),
            'highlights' => Highlight::query()
                ->orderBy('sort_order')
                ->pluck('text')
                ->values()
                ->toArray(),
            'skills' => SkillCategory::query()
                ->orderBy('sort_order')
                ->get()
                ->map(function (SkillCategory $category) {
                    return [
                        'title' => $category->title,
                        'skills' => $category->skills->map(fn ($skill) => [
                            'name' => $skill->name,
                            'icon' => $skill->icon,
                            'level' => $skill->level,
                            'years' => $skill->years,
                            'note' => $skill->note,
                        ])->values()->toArray(),
                    ];
                })
                ->values()
                ->toArray(),
            'experience' => Experience::query()
                ->orderBy('sort_order')
                ->get()
                ->map(fn (Experience $exp) => $exp->toPortfolioArray())
                ->values()
                ->toArray(),
            'projects' => Project::query()
                ->orderBy('sort_order')
                ->get()
                ->map(fn (Project $project) => $project->toPortfolioArray())
                ->values()
                ->toArray(),
            'education' => Education::query()
                ->orderBy('sort_order')
                ->get()
                ->map(fn (Education $education) => [
                    'id' => (string) $education->id,
                    'degree' => $education->degree,
                    'school' => $education->school,
                    'location' => $education->location,
                    'date' => [
                        'start' => $education->start_date,
                        'end' => $education->end_date,
                        'present' => (bool) $education->is_present,
                    ],
                    'summary' => $education->summary,
                ])
                ->values()
                ->toArray(),
            'certifications' => Certification::query()
                ->orderBy('sort_order')
                ->get()
                ->map(fn (Certification $cert) => [
                    'id' => (string) $cert->id,
                    'name' => $cert->name,
                    'issuer' => $cert->issuer,
                    'url' => $cert->url,
                    'date' => [
                        'start' => $cert->start_date,
                        'end' => $cert->end_date,
                        'present' => (bool) $cert->is_present,
                    ],
                    'description' => $cert->description,
                ])
                ->values()
                ->toArray(),
            'socials' => SocialLink::query()
                ->orderBy('sort_order')
                ->get()
                ->map(fn (SocialLink $link) => [
                    'label' => $link->label,
                    'url' => $link->url,
                    'icon' => $link->icon,
                    'size' => $link->size,
                ])
                ->values()
                ->toArray(),
            'extras' => [
                'languages' => [],
                'interests' => [],
            ],
        ];
    }

    private function personal(?Profile $profile): array
    {
        if (! $profile) {
            return [
                'name' => 'Parel Kirby',
                'title' => 'Student / Developer',
                'headline' => 'Student / Developer',
                'summary' => '',
                'hero' => ['summary' => ''],
                'avatar' => ['url' => 'images/parel.jpg', 'label' => 'Parel Kirby'],
                'contact' => [],
            ];
        }

        return [
            'name' => $profile->name,
            'title' => $profile->title,
            'headline' => $profile->headline,
            'avatar' => [
                'url' => $profile->avatar_path,
                'label' => $profile->avatar_label ?? $profile->name,
            ],
            'summary' => $profile->summary,
            'hero' => [
                'summary' => $profile->hero_summary ?? $profile->summary,
            ],
            'contact' => [
                'email' => $profile->email,
                'phone' => $profile->phone,
                'location' => $profile->location,
            ],
        ];
    }
}
