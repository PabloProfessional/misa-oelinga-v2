<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $provinces = [
            [
                'name' => 'Eastern Cape',
                'url' => 'eastern-cape',
                'logo' => 'eastern-cape.png',
            ],
            [
                'name' => 'Free State',
                'url' => 'free-state',
                'logo' => 'free-state.png',
            ],
            [
                'name' => 'Gauteng',
                'url' => 'gauteng',
                'logo' => 'gauteng.png',
            ],
            [
                'name' => 'KwaZulu-Natal',
                'url' => 'kwaZulu-natal',
                'logo' => 'kwaZulu-natal.png',
            ],
            [
                'name' => 'Limpopo',
                'url' => 'limpopo',
                'logo' => 'limpopo.png',
            ],
            [
                'name' => 'Mpumalanga',
                'url' => 'mpumalanga',
                'logo' => 'mpumalanga.png',
            ],
            [
                'name' => 'North West',
                'url' => 'north-west',
                'logo' => 'north-west.png',
            ],
            [
                'name' => 'Northern Cape',
                'url' => 'northern-cape',
                'logo' => 'northern-cape.png',
            ],
            [
                'name' => 'Western Cape',
                'url' => 'western-cape',
                'logo' => 'western-cape.png',
            ],
        ];

        foreach ($provinces as $province) {
            Province::create([
                'name' => $province['name'],
                'url' => $province['url'],
                'logo' => $province['logo']
            ]);
        }

    }
}
