<?php

namespace Database\Seeders;

use App\Models\StatusType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $status_types = [
            [
                'name' => 'On Track',
                'description' => 'The budget is currently within the expected range and progressing as planned.',
                'category' => 'Budget',
                'color' => 'green',
                'url' => 'budget-on-track',
                'icon' => 'bi-check-circle-fill',
            ],
            [
                'name' => 'Underspend',
                'description' => 'Less money is being spent than was budgeted for this period.',
                'category' => 'Budget',
                'color' => 'blue',
                'url' => 'budget-underspend',
                'icon' => 'bi-arrow-down-circle-fill',
            ],
            [
                'name' => 'Overspend',
                'description' => 'More money is being spent than was budgeted for this period.',
                'category' => 'Budget',
                'color' => 'red',
                'url' => 'budget-overspend',
                'icon' => 'bi-arrow-up-circle-fill',
            ],
            [
                'name' => 'Not Applicable',
                'description' => 'The budget status does not apply in this context.',
                'category' => 'Budget',
                'color' => 'gray',
                'url' => 'budget-not-applicable',
                'icon' => 'bi-slash-circle-fill',
            ],
            [
                'name' => 'Not Started',
                'description' => 'The project or task has not yet started.',
                'category' => 'Schedule',
                'color' => 'orange',
                'url' => 'schedule-not-started',
                'icon' => 'bi-hourglass-split',
            ],
            [
                'name' => 'On Schedule',
                'description' => 'The project or task is progressing as planned and is on schedule.',
                'category' => 'Schedule',
                'color' => 'teal',
                'url' => 'schedule-on-schedule',
                'icon' => 'bi-clock-fill',
            ],
            [
                'name' => 'Late',
                'description' => 'The project or task is behind schedule.',
                'category' => 'Schedule',
                'color' => 'purple',
                'url' => 'schedule-late',
                'icon' => 'bi-exclamation-circle-fill',
            ],
            [
                'name' => 'No Schedule Applicable',
                'description' => 'The status does not apply in this context.',
                'category' => 'Schedule',
                'color' => 'pink',
                'url' => 'schedule-not-applicable',
                'icon' => 'bi-x-circle-fill',
            ],
            [
                'name' => 'Low Risk',
                'description' => 'The project or task has a low level of risk.',
                'category' => 'Risk',
                'color' => 'lightgreen',
                'url' => 'risk-low',
                'icon' => 'bi-shield-fill-check',
            ],
            [
                'name' => 'Medium Risk',
                'description' => 'The project or task has a medium level of risk.',
                'category' => 'Risk',
                'color' => 'yellow',
                'url' => 'risk-medium',
                'icon' => 'bi-exclamation-triangle-fill',
            ],
            [
                'name' => 'High Risk',
                'description' => 'The project or task has a high level of risk.',
                'category' => 'Risk',
                'color' => 'darkred',
                'url' => 'risk-high',
                'icon' => 'bi-shield-fill-exclamation',
            ],
            [
                'name' => 'Yes',
                'description' => 'Procurement has been completed for this project or task.',
                'category' => 'Procurement',
                'color' => 'green-yellow',
                'url' => 'procurement-yes',
                'icon' => 'bi-check2-circle-fill',
            ],
            [
                'name' => 'No',
                'description' => 'No procurement has been done for this project or task.',
                'category' => 'Procurement',
                'color' => 'red-blue',
                'url' => 'procurement-no',
                'icon' => 'bi-terminal-dash',
            ],
            [
                'name' => 'Procurement in Progress',
                'description' => 'The procurement process is currently ongoing for this project or task.',
                'category' => 'Procurement',
                'color' => 'orange-red',
                'url' => 'procurement-in-progress',
                'icon' => 'bi-arrow-repeat',
            ],
            [
                'name' => 'No Procurement Applicable',
                'description' => 'No procurement is applicable for this project or task.',
                'category' => 'Procurement',
                'color' => 'gray-orange',
                'url' => 'procurement-not-applicable',
                'icon' => 'bi-terminal-fill',
            ],
        ];





        foreach ($status_types as $status) {
            StatusType::create([
                'name' => $status['name'],
                'category' => $status['category'],
                'description' => $status['description'],
                'url' => $status['url'],
                'icon' => $status['icon'],
                'color' => $status['color']
            ]);
        }
    }
}
