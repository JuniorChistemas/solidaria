<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_administrador =   Role::create(['name' => 'administrador', 'state' => true]);
        $role_vendedor =  Role::create(['name' => 'vendedor', 'state' => true]);
        $role_almacen = Role::create(['name' => 'almacen', 'state' => false]);
    }
}
