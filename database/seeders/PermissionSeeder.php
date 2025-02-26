<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ! Permissions are created for each module
        //Permissions for Doctor Module
        Permission::create(['name' => 'create doctors']);
        Permission::create(['name' => 'view doctors']);
        Permission::create(['name' => 'edit doctors']);
        Permission::create(['name' => 'delete doctors']);
        // Permissions for categories module
        Permission::create(['name' => 'view categories']);
        Permission::create(['name' => 'create categories']);
        Permission::create(['name' => 'update categories']);
        Permission::create(['name' => 'delete categories']);
        // Permissions for supplier module
        Permission::create(['name' => 'create suppliers']);
        Permission::create(['name' => 'view suppliers']);
        Permission::create(['name' => 'edit suppliers']);
        Permission::create(['name' => 'delete suppliers']);
        // Permissions for Laboratory module
        Permission::create(['name' => 'create laboratories']);
        Permission::create(['name' => 'view laboratories']);
        Permission::create(['name' => 'edit laboratories']);
        Permission::create(['name' => 'delete laboratories']);
    }
}
