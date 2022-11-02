<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['name' => 'Moderna','shelf_life' => 210,'minimum_temperature' => -100,'maximum_temperature' => -20],
            ['name' => 'Phizer','shelf_life' => 180,'minimum_temperature' => -100,'maximum_temperature' => -60],


        ];
        foreach ($items as $item) {
            Type::create($item);
        }
    }
}
