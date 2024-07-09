<?php

namespace Database\Seeders;

use App\Models\Sector;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $sectors = [
            [
                'name' => 'All',
                'description' => 'All sectors combined',
                'icon' => 'bi-grid-fill'
            ],
            [
                'name' => 'Electricity',
                'description' => 'Sector related to electricity supply and distribution',
                'icon' => 'bi-lightning-fill'
            ],
            [
                'name' => 'Water and Sanitation',
                'description' => 'Sector related to water supply and sanitation services',
                'icon' => 'bi-droplet-fill'
            ],
            [
                'name' => 'Roads',
                'description' => 'Sector related to road infrastructure and maintenance',
                'icon' => 'bi-geo-alt-fill'
            ],
            [
                'name' => 'Sewage',
                'description' => 'Sector related to sewage systems and treatment',
                'icon' => 'bi-trash-fill'
            ],
            [
                'name' => 'Refuse removal',
                'description' => 'Sector related to waste collection and disposal',
                'icon' => 'bi-trash2-fill'
            ],
            [
                'name' => 'Health',
                'description' => 'Sector related to healthcare services',
                'icon' => 'bi-heart-fill'
            ],
            [
                'name' => 'Recreation',
                'description' => 'Sector related to recreational facilities and services',
                'icon' => 'bi-tree-fill'
            ],
            [
                'name' => 'Education',
                'description' => 'Sector related to educational institutions and services',
                'icon' => 'bi-book-fill'
            ],
            [
                'name' => 'Not Applicable',
                'description' => 'Not applicable sector',
                'icon' => 'bi-x-circle-fill'
            ]
        ];


        foreach ($sectors as $sector) {
            Sector::create([
                'name' => $sector['name'],
                'description' => $sector['description'],
                'icon' => $sector['icon'],
                'url' => Str::slug($sector['name']),
                'logo' => Str::slug($sector['name']).'.png'
            ]);
        }
    }
}
