<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['name' => 'Danny Johansson','email' => "dann4624@edu.sde.dk",'password' => hash("sha512","Pass.1234"),'role_id' => Role::where('name','=','Administrator')->first()->id],
            ['name' => 'Nick Hansen','email' => "nick",'password' => hash("sha512","1234"),'role_id' => Role::where('name','=','Lager Medarbejder')->first()->id],
            ['name' => 'Rasmus Nørby','email' => "rasm947f@edu.sde.dk",'password' => hash("sha512","Pass.1234"),'role_id' => Role::where('name','=','Lager Chef')->first()->id],
            ['name' => 'App Admin','email' => "app_admin",'password' => hash("sha512","1234"),'role_id' => Role::where('name','=','Administrator')->first()->id],
        ];
        foreach ($items as $item) {
            User::create($item);
        }
    }
}
