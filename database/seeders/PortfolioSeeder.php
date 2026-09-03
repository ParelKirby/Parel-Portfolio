<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\SkillCategory;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        Profile::query()->create([
            'name' => 'Parel Kirby',
            'title' => 'Student / Developer',
            'headline' => 'Student / Developer',
            'summary' => 'Quietly becoming stronger, wiser, and better. I may not have it all figured out, but I trust the journey and believe my best chapters are still ahead.',
            'hero_summary' => 'Quietly becoming stronger, wiser, and better. I may not have it all figured out, but I trust the journey and believe my best chapters are still ahead.',
            'email' => 'ballerachrisalyn@gmail.com',
            'phone' => '09396896440',
            'location' => 'Bucay, Abra',
            'avatar_path' => 'images/parel.jpg',
            'avatar_label' => 'Parel Kirby',
        ]);

        $groups = [
            'frontend' => [
                'title' => 'Frontend',
                'skills' => [
                    ['name' => 'HTML/CSS', 'icon' => 'SiHtml5'],
                    ['name' => 'JavaScript', 'icon' => 'SiJavascript'],
                    ['name' => 'React', 'icon' => 'SiReact'],
                    ['name' => 'Tailwind', 'icon' => 'SiTailwindcss'],
                ],
            ],
            'backend' => [
                'title' => 'Backend',
                'skills' => [
                    ['name' => 'PHP', 'icon' => 'SiPhp'],
                    ['name' => 'Laravel', 'icon' => 'SiLaravel'],
                    ['name' => 'MySQL', 'icon' => 'SiMysql'],
                ],
            ],
            'tools' => [
                'title' => 'Tools',
                'skills' => [
                    ['name' => 'Git', 'icon' => 'SiGit'],
                    ['name' => 'GitHub', 'icon' => 'SiGithub'],
                    ['name' => 'VS Code', 'icon' => 'SiVisualstudiocode'],
                ],
            ],
        ];

        foreach ($groups as $slug => $group) {
            $category = SkillCategory::query()->create([
                'title' => $group['title'],
                'slug' => $slug,
            ]);

            foreach ($group['skills'] as $index => $skill) {
                Skill::query()->create([
                    'skill_category_id' => $category->id,
                    'name' => $skill['name'],
                    'icon' => $skill['icon'],
                    'sort_order' => $index,
                ]);
            }
        }

        Project::query()->create([
            'slug' => 'saint-james-elders',
            'title' => 'Online Information and Management System for Saint James Elders',
            'short' => 'A centralized web-based capstone project to streamline records management and improve administrative workflows.',
            'description' => 'A centralized web-based capstone project designed to streamline records management and improve administrative workflows for Saint James Elders. Developed using Laravel, PHP, MySQL, HTML/CSS, and JavaScript.',
            'tags' => ['Laravel', 'PHP', 'MySQL', 'HTML/CSS', 'JavaScript', 'Capstone'],
            'links' => [],
            'is_under_development' => true,
            'featured' => true,
            'sort_order' => 0,
        ]);

        Education::query()->create([
            'degree' => 'Tertiary',
            'school' => 'Data Center College of Bangued',
            'start_date' => '2023',
            'is_present' => true,
            'sort_order' => 0,
        ]);

        Education::query()->create([
            'degree' => 'Secondary',
            'school' => 'Our Lady of Fatima School',
            'start_date' => '2021',
            'end_date' => '2023',
            'sort_order' => 1,
        ]);
    }
}
