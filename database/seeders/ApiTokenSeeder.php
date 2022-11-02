<?php

namespace Database\Seeders;

use App\Models\Apitoken;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApiTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp = now();

        $items = [
            ['token' => hash('sha512',"adminpanel_admin".$timestamp),"role_id" => 1,"target_id" => 3],
            ['token' => hash('sha512',"adminpanel_lager_medarbejder".$timestamp),"role_id" => 2,"target_id" => 3],
            ['token' => hash('sha512',"adminpanel_lager_chef".$timestamp),"role_id" => 3,"target_id" => 3],

            ['token' => hash('sha512',"app_admin".$timestamp),"role_id" => 2,"target_id" => 1],
            ['token' => hash('sha512',"app_lager_medarbejder".$timestamp),"role_id" => 2,"target_id" => 1],
            ['token' => hash('sha512',"app_lager_chef".$timestamp),"role_id" => 3,"target_id" => 1],

            ['token' => hash('sha512',"zone_controller".$timestamp),"role_id" => 4,"target_id" => 2],

            ['token' => "demo_admin","role_id" => 1,"target_id" => 4],
            ['token' => "demo_lager_medarbejder","role_id" => 2,"target_id" => 4],
            ['token' => "demo_lager_chef","role_id" => 3,"target_id" => 4],

        ];
        foreach ($items as $item) {
            Apitoken::create($item);
        }
    }
}
