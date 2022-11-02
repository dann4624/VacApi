<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['name' => 'Zone 1'],
            ['name' => 'Zone 2'],
            ['name' => 'Zone 3'],
        ];
        foreach ($items as $item) {
            Position::create($item);
        }
    }
}
