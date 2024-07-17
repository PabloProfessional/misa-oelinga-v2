<?php

namespace Database\Seeders;

use App\Models\UserActivityType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserActivityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $activityTypes = [
            [
                'name' => 'User login',
                'description' => 'User has logged into the system',
                'icon' => 'bi bi-person-fill-up'
            ],
            [
                'name' => 'User logout',
                'description' => 'User has logged out of the system',
                'icon' => 'bi bi-person-fill-down'
            ],
        ];

        foreach ($activityTypes as $activityType) {
            UserActivityType::firstOrCreate(['name' => $activityType['name']], $activityType);
        }
    }
}
