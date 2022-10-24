<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            ['name' => 'tokens_viewAny'],
            ['name' => 'tokens_viewAny_deleted'],
            ['name' => 'tokens_view'],
            ['name' => 'tokens_create'],
            ['name' => 'tokens_edit'],
            ['name' => 'tokens_edit_role'],
            ['name' => 'tokens_edit_username'],
            ['name' => 'tokens_delete'],
            ['name' => 'tokens_delete_force'],
            ['name' => 'tokens_restore'],
            ['name' => 'targets_viewAny'],
            ['name' => 'targets_viewAny_deleted'],
            ['name' => 'targets_view'],
            ['name' => 'targets_create'],
            ['name' => 'targets_edit'],
            ['name' => 'targets_edit_role'],
            ['name' => 'targets_edit_username'],
            ['name' => 'targets_delete'],
            ['name' => 'targets_delete_force'],
            ['name' => 'targets_restore'],
            ['name' => 'roles_viewAny'],
            ['name' => 'roles_viewAny_deleted'],
            ['name' => 'roles_view'],
            ['name' => 'roles_create'],
            ['name' => 'roles_edit'],
            ['name' => 'roles_edit_role'],
            ['name' => 'roles_edit_username'],
            ['name' => 'roles_delete'],
            ['name' => 'roles_delete_force'],
            ['name' => 'roles_restore'],
            ['name' => 'users_viewAny'],
            ['name' => 'users_viewAny_deleted'],
            ['name' => 'users_viewAny'],
            ['name' => 'users_viewAny_deleted'],
            ['name' => 'users_view'],
            ['name' => 'users_create'],
            ['name' => 'users_edit'],
            ['name' => 'users_edit_role'],
            ['name' => 'users_edit_username'],
            ['name' => 'users_delete'],
            ['name' => 'users_delete_force'],
            ['name' => 'users_restore'],
            ['name' => 'users_viewAny'],
            ['name' => 'users_viewAny_deleted'],
        ];
        foreach ($items as $item) {
            Permission::create($item);
        }
    }
}
