<?php

namespace Database\Seeders;

use App\Models\Administrator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $admins = [
            'pablo@oelinga.com',
            'muigzn@gmail.com',
            'zadok@oelinga.com',
            'michelle@oelinga.com',
        ];

        foreach ($admins as $admin) {
            Administrator::create([
                'email' => $admin,
                'active' => true,
            ]);
        }
    }
}
