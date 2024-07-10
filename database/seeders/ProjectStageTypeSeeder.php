<?php

namespace Database\Seeders;

use App\Models\ProjectStageType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectStageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $stage_types = [
            [
                'name' => 'Initiation',
                'description' => 'Project initiation stage where the objectives, scope, and stakeholders are identified.',
                'color' => 'blue',
                'url' => 'blue',
                'icon' => 'bi-arrow-up-circle-fill',
            ],
            [
                'name' => 'Concept',
                'description' => 'The stage where initial ideas and concepts are developed and explored.',
                'color' => 'green',
                'url' => 'green',
                'icon' => 'bi-lightbulb-fill',
            ],
            [
                'name' => 'Design Development',
                'description' => 'In this stage, the chosen concept is developed into a detailed design.',
                'color' => 'orange',
                'url' => 'orange',
                'icon' => 'bi-pencil-square',
            ],
            [
                'name' => 'Design Documentation',
                'description' => 'Creation of detailed documentation including technical drawings and specifications.',
                'color' => 'purple',
                'url' => 'purple',
                'icon' => 'bi-journal-text',
            ],
            [
                'name' => 'Works/Execution',
                'description' => 'Physical construction or execution of the project according to the design.',
                'color' => 'red',
                'url' => 'red',
                'icon' => 'bi-tools',
            ],
            [
                'name' => 'Handover',
                'description' => 'The stage where the completed project is handed over to the client or end-users.',
                'color' => 'cyan',
                'url' => 'cyan',
                'icon' => 'bi-box-arrow-up-right',
            ],
            [
                'name' => 'Complete',
                'description' => 'Final stage indicating the successful completion and closure of the project.',
                'color' => 'gray',
                'url' => 'gray',
                'icon' => 'bi-check-circle-fill',
            ],
        ];

        foreach ($stage_types as $stage_type) {
            ProjectStageType::create($stage_type);
        }
    }
}
