<?php

namespace Database\Seeders;

use App\Models\Type;
use App\Models\Zone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ZoneSeeder extends Seeder
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
            Zone::create($item);
        }

        Zone::where('name', '=', 'Zone 1')->first()->types()->sync(Type::where('name','=','Moderna')->first());
        Zone::where('name', '=', 'Zone 2')->first()->types()->sync(Type::where('name','=','Phizer')->first());
        Zone::where('name', '=', 'Zone 3')->first()->types()->sync(Type::all());
    }
}
