<?php

namespace Database\Seeders;

use App\Models\Apitarget;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApiTargetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['name' => 'App'],
            ['name' => 'Zone-Controller'],
            ['name' => 'Admin-Panel'],
        ];
        foreach ($items as $item) {
            Apitarget::create($item);
        }
    }
}
