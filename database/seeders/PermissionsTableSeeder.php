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

        Permission::create(['name' => 'currencies.index']);
        Permission::create(['name' => 'currencies.edit']);
        Permission::create(['name' => 'currencies.show']);
        Permission::create(['name' => 'currencies.create']);
        Permission::create(['name' => 'currencies.destroy']);

        Permission::create(['name' => 'warehouses.index']);
        Permission::create(['name' => 'warehouses.edit']);
        Permission::create(['name' => 'warehouses.show']);
        Permission::create(['name' => 'warehouses.create']);
        Permission::create(['name' => 'warehouses.destroy']);

        Permission::create(['name' => 'trans_companies.index']);
        Permission::create(['name' => 'trans_companies.edit']);
        Permission::create(['name' => 'trans_companies.show']);
        Permission::create(['name' => 'trans_companies.create']);
        Permission::create(['name' => 'trans_companies.destroy']);

        Permission::create(['name' => 'suppl_cond_sales.index']);
        Permission::create(['name' => 'suppl_cond_sales.edit']);
        Permission::create(['name' => 'suppl_cond_sales.show']);
        Permission::create(['name' => 'suppl_cond_sales.create']);
        Permission::create(['name' => 'suppl_cond_sales.destroy']);

        Permission::create(['name' => 'custom_agents.index']);
        Permission::create(['name' => 'custom_agents.edit']);
        Permission::create(['name' => 'custom_agents.show']);
        Permission::create(['name' => 'custom_agents.create']);
        Permission::create(['name' => 'custom_agents.destroy']);

        Permission::create(['name' => 'factoring.quote.index']);
        Permission::create(['name' => 'factoring.quote.edit']);
        Permission::create(['name' => 'factoring.quote.show']);
        Permission::create(['name' => 'factoring.quote.create']);
        Permission::create(['name' => 'factoring.quote.destroy']);

        Permission::create(['name' => 'factoring.applications.index']);
        Permission::create(['name' => 'factoring.applications.edit']);
        Permission::create(['name' => 'factoring.applications.show']);
        Permission::create(['name' => 'factoring.applications.create']);

        Permission::create(['name' => 'factoring.disbursements.index']);
        Permission::create(['name' => 'factoring.disbursements.edit']);
        Permission::create(['name' => 'factoring.disbursements.show']);
        Permission::create(['name' => 'factoring.disbursements.create']);
        Permission::create(['name' => 'factoring.disbursements.destroy']);

        // admin factoring
        Permission::create(['name' => 'admin.factoring.applications.index']);
        Permission::create(['name' => 'admin.factoring.applications.edit']);
        Permission::create(['name' => 'admin.factoring.applications.show']);
        Permission::create(['name' => 'admin.factoring.applications.create']);

        Permission::create(['name' => 'admin.clients.index']);
        Permission::create(['name' => 'admin.clients.edit']);
        Permission::create(['name' => 'admin.clients.show']);
        Permission::create(['name' => 'admin.clients.create']);
        Permission::create(['name' => 'admin.clients.destroy']);

        Permission::create(['name' => 'admin.factoring.disbursements.index']);
        Permission::create(['name' => 'admin.factoring.disbursements.edit']);
        Permission::create(['name' => 'admin.factoring.disbursements.show']);
        Permission::create(['name' => 'admin.factoring.disbursements.create']);
        Permission::create(['name' => 'admin.factoring.disbursements.destroy']);

        Permission::create(['name' => 'admin.factoring.fees_history.index']);
        Permission::create(['name' => 'admin.factoring.fees_history.edit']);
        Permission::create(['name' => 'admin.factoring.fees_history.show']);
        Permission::create(['name' => 'admin.factoring.fees_history.create']);
        Permission::create(['name' => 'admin.factoring.fees_history.destroy']);

        Permission::create(['name' => 'admin.factoring.quote.index']);
        Permission::create(['name' => 'admin.factoring.quote.edit']);
        Permission::create(['name' => 'admin.factoring.quote.show']);
        Permission::create(['name' => 'admin.factoring.quote.create']);
        Permission::create(['name' => 'admin.factoring.quote.destroy']);


        Permission::create(['name' => 'settings.index']);
        Permission::create(['name' => 'settings.edit']);
        Permission::create(['name' => 'settings.show']);
        Permission::create(['name' => 'settings.create']);
        Permission::create(['name' => 'settings.destroy']);



        //Admin
        $admin = Role::create(['name' => 'Admin']);

       
        //Client
        $client = Role::create(['name' => 'Client']);

        $client->givePermissionTo([
            'clients.index',
            'custom_agents.index',
            'custom_agents.edit',
            'custom_agents.create',
            'custom_agents.show',
            'custom_agents.destroy',
            'factoring.applications.index',
            'factoring.applications.edit',
            'factoring.applications.show',
            'factoring.applications.create',
            'factoring.disbursements.index',
            'factoring.disbursements.edit',
            'factoring.disbursements.show',
            'factoring.disbursements.create',
            'factoring.disbursements.destroy',
            'factoring.quote.index',
            'factoring.quote.edit',
            'factoring.quote.show',
            'factoring.quote.create',
            'factoring.quote.destroy',
        ]);

        $operator = Role::create(['name' => 'operator']);

        $operator->givePermissionTo([
            'admin.factoring.applications.index',
            'admin.factoring.applications.edit',
            'admin.factoring.applications.show',
            'admin.factoring.fees_history.index',
            'admin.factoring.fees_history.show',
            'admin.factoring.fees_history.edit',
            'admin.factoring.quote.index',
            'admin.factoring.quote.show',
            'admin.clients.index',
            'admin.clients.show',
            'admin.factoring.disbursements.index',
            'admin.factoring.disbursements.edit',
            'admin.factoring.disbursements.show',
        ]);

        $business_executive = Role::create(['name' => 'business_executive']);

        $business_executive->givePermissionTo([
            'admin.factoring.fees_history.index',
            'admin.factoring.fees_history.show',
            'admin.factoring.applications.index',
            'admin.factoring.applications.show',
            'admin.factoring.quote.index',
            'admin.factoring.quote.show',
            'admin.clients.index',
            'admin.clients.show',
            'admin.factoring.disbursements.index',
            'admin.factoring.disbursements.show',
        ]);


        //User Admin
        $user = User::find(1); 
        $user->assignRole('Admin');

        //User Client
        $client = User::find(2); 
        $client->assignRole('Client');

         //User Operator
         $user = User::find(3); 
         $user->assignRole('operator');
 
         //User Business_executive
         $user = User::find(4); 
         $user->assignRole('business_executive');
 
         //User Business_executive
         $user = User::find(5); 
         $user->assignRole('business_executive');

    }
}
