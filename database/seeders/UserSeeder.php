<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // get the roles 
        $role_administrador =   Role::findByName('administrador');
        $role_vendedor =  Role::findByName('vendedor');
        $role_almacen = Role::findByName('almacen');
        // get the permissions
        $permissions_admin = Permission::all()->pluck('name')->toArray();
        $permissions_sales = ['create doctors', 'view doctors'];

        // create the users
        $user = User::create([
            'name' => 'jesus Junior',
            'email' => 'junior15062023@gmail.com',
            'password' => Hash::make('junior123'),
        ]);

        $user2 = User::create([
            'name' => 'gustavo siancas',
            'email' => 'gustavo@gmail.com',
            'password' => Hash::make('gustavo123'),
        ]);
        $user3 = User::create([
            'name' => 'karin santamaria',
            'email' => 'karinsntmr@gmail.com',
            'password' => Hash::make('karin2706'),
        ]);
        $user4 = User::create([
            'name' => 'Anthony Marck',
            'email' => 'thonymarck385213xd@gmail.com',
            'password' => Hash::make('123456'),
        ]);
        $user6 = User::create([
            'name' => 'bryan rebaza',
            'email' => 'bryanrebaza@gmail.com',
            'password' => Hash::make('123456'),
         ]);
        $user5 = User::create([
            'name' => 'palupug',
            'email' => 'pablolupux@gmail.com',
            'password' => Hash::make('Pl221103%'),
        ]);
        // link the roles with the permissions
        $role_administrador->syncPermissions($permissions_admin);
        $role_vendedor->syncPermissions($permissions_sales);
        // assuming the roles of the users
        $user->assignRole($role_administrador);
        $user2->assignRole($role_administrador);
        $user3->assignRole($role_administrador);
        $user4->assignRole($role_administrador);
        $user5->assignRole($role_administrador);
        $user6->assignRole($role_administrador);
    }
}
