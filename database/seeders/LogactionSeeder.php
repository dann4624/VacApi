<?php

namespace Database\Seeders;

use App\Models\LogAction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LogactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['name' => 'Create'],
            ['name' => 'Update'],
            ['name' => 'Delete'],
            ['name' => 'Force_Delete'],
            ['name' => 'Restore'],
            ['name' => 'Move'],
            ['name' => 'Data'],
        ];
        foreach ($items as $item) {
            Logaction::create($item);
        }
    }
}
