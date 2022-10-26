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
            ['name' => 'logActions_viewAny'],
            ['name' => 'logActions_viewAny_deleted'],
            ['name' => 'logActions_view'],
            ['name' => 'logActions_create'],
            ['name' => 'logActions_edit'],
            ['name' => 'logActions_delete'],
            ['name' => 'logActions_delete_force'],
            ['name' => 'logActions_restore'],

            ['name' => 'targets_viewAny'],
            ['name' => 'targets_viewAny_deleted'],
            ['name' => 'targets_view'],
            ['name' => 'targets_create'],
            ['name' => 'targets_edit'],
            ['name' => 'targets_delete'],
            ['name' => 'targets_delete_force'],
            ['name' => 'targets_restore'],

            ['name' => 'permissions_viewAny'],
            ['name' => 'permissions_viewAny_deleted'],
            ['name' => 'permissions_view'],
            ['name' => 'permissions_create'],
            ['name' => 'permissions_edit'],
            ['name' => 'permissions_delete'],
            ['name' => 'permissions_delete_force'],
            ['name' => 'permissions_restore'],

            ['name' => 'roles_viewAny'],
            ['name' => 'roles_viewAny_deleted'],
            ['name' => 'roles_view'],
            ['name' => 'roles_create'],
            ['name' => 'roles_edit'],
            ['name' => 'roles_edit_permissions'],
            ['name' => 'roles_delete'],
            ['name' => 'roles_delete_force'],
            ['name' => 'roles_restore'],

            ['name' => 'tokens_viewAny'],
            ['name' => 'tokens_viewAny_deleted'],
            ['name' => 'tokens_view'],
            ['name' => 'tokens_create'],
            ['name' => 'tokens_edit'],
            ['name' => 'tokens_delete'],
            ['name' => 'tokens_delete_force'],
            ['name' => 'tokens_restore'],

            ['name' => 'users_viewAny'],
            ['name' => 'users_viewAny_deleted'],
            ['name' => 'users_view'],
            ['name' => 'users_create'],
            ['name' => 'users_edit'],
            ['name' => 'users_delete'],
            ['name' => 'users_delete_force'],
            ['name' => 'users_restore'],

            ['name' => 'logs_viewAny'],
            ['name' => 'logs_viewAny_deleted'],
            ['name' => 'logs_view'],
            ['name' => 'logs_create'],
            ['name' => 'logs_edit'],
            ['name' => 'logs_delete'],
            ['name' => 'logs_delete_force'],
            ['name' => 'logs_restore'],

            ['name' => 'zones_viewAny'],
            ['name' => 'zones_viewAny_deleted'],
            ['name' => 'zones_view'],
            ['name' => 'zones_create'],
            ['name' => 'zones_edit'],
            ['name' => 'zones_delete'],
            ['name' => 'zones_delete_force'],
            ['name' => 'zones_restore'],

            ['name' => 'zoneLogs_viewAny'],
            ['name' => 'zoneLogs_viewAny_deleted'],
            ['name' => 'zoneLogs_view'],
            ['name' => 'zoneLogs_create'],
            ['name' => 'zoneLogs_edit'],
            ['name' => 'zoneLogs_delete'],
            ['name' => 'zoneLogs_delete_force'],
            ['name' => 'zoneLogs_restore'],

            ['name' => 'shelves_viewAny'],
            ['name' => 'shelves_viewAny_deleted'],
            ['name' => 'shelves_view'],
            ['name' => 'shelves_create'],
            ['name' => 'shelves_edit'],
            ['name' => 'shelves_delete'],
            ['name' => 'shelves_delete_force'],
            ['name' => 'shelves_restore'],

            ['name' => 'types_viewAny'],
            ['name' => 'types_viewAny_deleted'],
            ['name' => 'types_view'],
            ['name' => 'types_create'],
            ['name' => 'types_edit'],
            ['name' => 'types_delete'],
            ['name' => 'types_delete_force'],
            ['name' => 'types_restore'],

            ['name' => 'boxes_viewAny'],
            ['name' => 'boxes_viewAny_deleted'],
            ['name' => 'boxes_view'],
            ['name' => 'boxes_create'],
            ['name' => 'boxes_edit'],
            ['name' => 'boxes_delete'],
            ['name' => 'boxes_delete_force'],
            ['name' => 'boxes_restore'],

            ['name' => 'boxLogs_viewAny'],
            ['name' => 'boxLogs_viewAny_deleted'],
            ['name' => 'boxLogs_view'],
            ['name' => 'boxLogs_create'],
            ['name' => 'boxLogs_edit'],
            ['name' => 'boxLogs_delete'],
            ['name' => 'boxLogs_delete_force'],
            ['name' => 'boxLogs_restore'],
        ];
        foreach ($items as $item) {
            Permission::create($item);
        }
    }
}
