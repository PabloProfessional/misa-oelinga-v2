<?php

namespace Database\Seeders;

use App\Models\Programme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgrammeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $programmes = [
            [
                'name' => 'Capacity Building',
                'description' => 'Program focused on enhancing the skills and capabilities of individuals or organizations.',
                'url' => 'capacity-building',
                'icon' => 'bi-people-fill',
                'logo' => 'capacity-building-logo.png'
            ],
            [
                'name' => 'Business Improvement',
                'description' => 'Program aimed at enhancing business processes and operations to achieve better results.',
                'url' => 'business-improvement',
                'icon' => 'bi-graph-up',
                'logo' => 'business-improvement-logo.png'
            ],
            [
                'name' => 'Technical Advisory Support',
                'description' => 'Program providing technical expertise and guidance to address specific challenges or opportunities.',
                'url' => 'technical-advisory-support',
                'icon' => 'bi-gear-fill',
                'logo' => 'technical-advisory-support-logo.png'
            ]
        ];

        foreach ($programmes as $program) {
            Programme::create([
                'name' => $program['name'],
                'description' => $program['description'],
                'url' => $program['url'],
                'icon' => $program['icon'],
                'logo' => $program['logo']
            ]);
        }
    }
}
