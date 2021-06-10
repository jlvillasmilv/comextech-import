<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Permission list
        Permission::create(['name' => 'admin.applications.index']);
        Permission::create(['name' => 'admin.applications.edit']);
        Permission::create(['name' => 'admin.applications.show']);
        Permission::create(['name' => 'admin.applications.create']);
        Permission::create(['name' => 'admin.applications.destroy']);
      
        Permission::create(['name' => 'clients.index']);
        Permission::create(['name' => 'clients.edit']);
        Permission::create(['name' => 'clients.show']);
        Permission::create(['name' => 'clients.create']);
        Permission::create(['name' => 'clients.destroy']);
       
        Permission::create(['name' => 'users.index']);
        Permission::create(['name' => 'users.edit']);
        Permission::create(['name' => 'users.show']);
        Permission::create(['name' => 'users.create']);
        Permission::create(['name' => 'users.destroy']);

        Permission::create(['name' => 'services.index']);
        Permission::create(['name' => 'services.edit']);
        Permission::create(['name' => 'services.show']);
        Permission::create(['name' => 'services.create']);
        Permission::create(['name' => 'services.destroy']);
       
        //Admin
        $admin = Role::create(['name' => 'Admin']);
       
        //Client
        $client = Role::create(['name' => 'Client']);

         //Guest
        $guest = Role::create(['name' => 'Guest']);

        $guest->givePermissionTo([
            'clients.index',
        ]);

        //User Admin
        $user = User::find(1); 
        $user->assignRole('Admin');

        //User Client
        $client = User::find(2); 
        $client->assignRole('Client');

    }
}
