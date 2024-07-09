<?php

namespace Database\Seeders;

use App\Models\Municipality;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MunicipalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $municipalities = [
            ['name' => 'eThekwini Metropolitan', 'province_id' => 4 ,'url' => Str::slug('eThekwini Metropolitan'), 'logo' => Str::slug('eThekwini Metropolitan') . '.png', ],
            ['name' => 'City of Johannesburg Metropolitan municipality', 'province_id' => 3, 'url' => Str::slug('City of Johannesburg Metropolitan municipality'), 'logo' => Str::slug('City of Johannesburg Metropolitan municipality') . '.png'],
            ['name' => 'Chris Hani District Municipality', 'province_id' => 1,'url' => Str::slug('Chris Hani District Municipality'), 'logo' => Str::slug('Chris Hani District Municipality') . '.png'],
            ['name' => 'Buffalo City Metropolitan City', 'province_id' => 1 ,'url' => Str::slug('Buffalo City Metropolitan City'), 'logo' => Str::slug('Buffalo City Metropolitan City') . '.png'],
            ['name' => 'Mopani District Municipality', 'province_id' => 5, 'url' => Str::slug('Mopani District Municipality'), 'logo' => Str::slug('Mopani District Municipality') . '.png'],
            ['name' => 'Frances Baard District', 'province_id' => 8, 'url' => Str::slug('Frances Baard District'), 'logo' => Str::slug('Frances Baard District') . '.png'],
            ['name' => 'Dr Kenneth Kaunda District', 'province_id' => 7 ,'url' => Str::slug('Dr Kenneth Kaunda District'), 'logo' => Str::slug('Dr Kenneth Kaunda District') . '.png'],
            ['name' => 'City of Tswane Metropolitan', 'province_id' => 3, 'url' => Str::slug('City of Tswane Metropolitan'), 'logo' => Str::slug('City of Tswane Metropolitan') . '.png'],
            ['name' => 'Dr Ruth Segomotsi Mompati District', 'province_id' =>7 ,'url' => Str::slug('Dr Ruth Segomotsi Mompati District'), 'logo' => Str::slug('Dr Ruth Segomotsi Mompati District') . '.png'],
            ['name' => 'Vhembe District Muncipality', 'province_id' => 5 ,'url' => Str::slug('Vhembe District Muncipality'), 'logo' => Str::slug('Vhembe District Muncipality') . '.png'],
            ['name' => 'Capricorn District Municipality', 'province_id' => 5 ,'url' => Str::slug('Capricorn District Municipality'), 'logo' => Str::slug('Capricorn District Municipality') . '.png'],
            ['name' => 'Sedibeng District Municipality', 'province_id' => 3 ,'url' => Str::slug('Sedibeng District Municipality'), 'logo' => Str::slug('Sedibeng District Municipality') . '.png'],
            ['name' => 'iLembe District Municipality', 'province_id' => 4 ,'url' => Str::slug('iLembe District Municipality'), 'logo' => Str::slug('iLembe District Municipality') . '.png'],
            ['name' => 'Nelson Mandela Metropolitan City', 'province_id' => 1 ,'url' => Str::slug('Nelson Mandela Metropolitan City'), 'logo' => Str::slug('Nelson Mandela Metropolitan City') . '.png'],
            ['name' => 'Waterberg District Municipality', 'province_id' => 5 ,'url' => Str::slug('Waterberg District Municipality'), 'logo' => Str::slug('Waterberg District Municipality') . '.png'],
            ['name' => 'Alfred Nzo District Municipality', 'province_id' => 1 ,'url' => Str::slug('Alfred Nzo District Municipality'), 'logo' => Str::slug('Alfred Nzo District Municipality') . '.png'],
            ['name' => 'Metsweding District Municipality', 'province_id' => 3 ,'url' => Str::slug('Metsweding District Municipality'), 'logo' => Str::slug('Metsweding District Municipality') . '.png']
        ];

        foreach ($municipalities as $municipality) {
            Municipality::create($municipality);
        }
    }
}
