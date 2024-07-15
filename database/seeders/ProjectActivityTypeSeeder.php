<?php

namespace Database\Seeders;

use App\Models\ProjectActivityType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectActivityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $activity_types = [
            [
                'name' => 'Consulting',
                'description' => 'Providing expert advice or guidance in a particular field or industry.',
                'icon' => 'bi bi-person-circle', // Bootstrap Icons name for consulting
                'color' => '#FFA500', // Orange color
                'url' => Str::slug('Consulting'), // URL slug for consulting
            ],
            [
                'name' => 'Admin',
                'description' => 'Managing administrative tasks and operations within an organization.',
                'icon' => 'bi bi-file-earmark-text', // Bootstrap Icons name for admin
                'color' => '#008000', // Green color
                'url' => Str::slug('Admin'), // URL slug for admin
            ],
            [
                'name' => 'Engineering',
                'description' => 'Designing, building, and maintaining complex systems or structures.',
                'icon' => 'bi bi-tools', // Bootstrap Icons name for engineering
                'color' => '#0000FF', // Blue color
                'url' => Str::slug('Engineering'), // URL slug for engineering
            ],
            [
                'name' => 'Construction',
                'description' => 'Building physical infrastructure or structures according to plans and specifications.',
                'icon' => 'bi bi-hammer', // Bootstrap Icons name for construction
                'color' => '#FF0000', // Red color
                'url' => Str::slug('Construction'), // URL slug for construction
            ],
        ];


        foreach ($activity_types as $activity_type) {
            ProjectActivityType::create($activity_type);
        }
    }
}
