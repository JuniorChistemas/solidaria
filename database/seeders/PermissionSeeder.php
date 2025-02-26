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
        // ! se crea los permisos para cada modulo
        Permission::create(['name' => 'create doctors']);
        Permission::create(['name' => 'view doctors']);
        Permission::create(['name' => 'edit doctors']);
        Permission::create(['name' => 'delete doctors']);
        
        Permission::create(['name' => 'view categories']);
        Permission::create(['name' => 'create categories']);
        Permission::create(['name' => 'update categories']);
        Permission::create(['name' => 'delete categories']);
    }
}
