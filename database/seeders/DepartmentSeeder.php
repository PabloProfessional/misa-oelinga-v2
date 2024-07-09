<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $departments = [
            [
                'name' => 'Technical Support',
            ],
            [
                'name' => 'Infrastructure Delivery Management',
            ],
            [
                'name' => 'Risk Management'
            ],
            [
                'name' => 'Business Improvement'
            ]
        ];

        foreach ($departments as $department) {
            Department::create([
                'name' => $department['name'],
                'url' => Str::slug($department['name']),
                'logo' => Str::slug($department['name']).'.png'
            ]);
        }
    }
}
