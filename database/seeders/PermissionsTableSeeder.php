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

       
        Permission::create(['name' => 'import.application.index']);
        Permission::create(['name' => 'import.application.edit']);
        Permission::create(['name' => 'import.application.show']);
        Permission::create(['name' => 'import.application.create']);
        Permission::create(['name' => 'import.application.destroy']);

        Permission::create(['name' => 'client.company.index']);
        Permission::create(['name' => 'client.company.edit']);
        Permission::create(['name' => 'client.company.show']);
        Permission::create(['name' => 'client.company.create']);
        Permission::create(['name' => 'client.company.destroy']);

        Permission::create(['name' => 'client.address.index']);
        Permission::create(['name' => 'client.address.edit']);
        Permission::create(['name' => 'client.address.show']);
        Permission::create(['name' => 'client.address.create']);
        Permission::create(['name' => 'client.address.destroy']);

        Permission::create(['name' => 'admin.applications.index']);
        Permission::create(['name' => 'admin.applications.edit']);
        Permission::create(['name' => 'admin.applications.show']);
        Permission::create(['name' => 'admin.applications.create']);
        Permission::create(['name' => 'admin.applications.destroy']);

        Permission::create(['name' => 'admin.rates.air.index']);
        Permission::create(['name' => 'admin.rates.air.edit']);
        Permission::create(['name' => 'admin.rates.air.show']);
        Permission::create(['name' => 'admin.rates.air.create']);
        Permission::create(['name' => 'admin.rates.air.destroy']);

        Permission::create(['name' => 'admin.rates.fcl.index']);
        Permission::create(['name' => 'admin.rates.fcl.edit']);
        Permission::create(['name' => 'admin.rates.fcl.show']);
        Permission::create(['name' => 'admin.rates.fcl.create']);
        Permission::create(['name' => 'admin.rates.fcl.destroy']);

        Permission::create(['name' => 'admin.rates.lcl.index']);
        Permission::create(['name' => 'admin.rates.lcl.edit']);
        Permission::create(['name' => 'admin.rates.lcl.show']);
        Permission::create(['name' => 'admin.rates.lcl.create']);
        Permission::create(['name' => 'admin.rates.lcl.destroy']);

        Permission::create(['name' => 'admin.rates.local_transport.index']);
        Permission::create(['name' => 'admin.rates.local_transport.edit']);
        Permission::create(['name' => 'admin.rates.local_transport.show']);
        Permission::create(['name' => 'admin.rates.local_transport.create']);
        Permission::create(['name' => 'admin.rates.local_transport.destroy']);

        Permission::create(['name' => 'admin.rates.local_spending.index']);
        Permission::create(['name' => 'admin.rates.local_spending.edit']);
        Permission::create(['name' => 'admin.rates.local_spending.show']);
        Permission::create(['name' => 'admin.rates.local_spending.create']);
        Permission::create(['name' => 'admin.rates.local_spending.destroy']);

        Permission::create(['name' => 'admin.customs_exchange_rates.index']);
        Permission::create(['name' => 'admin.customs_exchange_rates.edit']);
        Permission::create(['name' => 'admin.customs_exchange_rates.show']);
        Permission::create(['name' => 'admin.customs_exchange_rates.create']);
        Permission::create(['name' => 'admin.customs_exchange_rates.destroy']);

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

        Permission::create(['name' => 'admin.freight_quotes.index']);
        Permission::create(['name' => 'admin.freight_quotes.edit']);
        Permission::create(['name' => 'admin.freight_quotes.show']);
        Permission::create(['name' => 'admin.freight_quotes.create']);
        Permission::create(['name' => 'admin.freight_quotes.destroy']);

        //Admin
        $admin = Role::create(['name' => 'Admin']);

       
        //Client
        $client = Role::create(['name' => 'Cliente']);

        $client->givePermissionTo([
            'client.address.index',
            'client.address.edit',
            'client.address.create',
            'client.address.show',
            'client.address.destroy',
            'client.company.index',
            'client.company.edit',
            'client.company.create',
            'client.company.show',
            'client.company.destroy',
            'import.application.index',
            'import.application.edit',
            'import.application.create',
            'import.application.show',
            'import.application.destroy',
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

        //Client limitado
        $client_limit = Role::create(['name' => 'ClienteLimitado']);

        $client_limit->givePermissionTo([
            'import.application.index',
            'import.application.edit',
            'import.application.create',
            'import.application.show',
            'import.application.destroy',
            'custom_agents.index',
            'custom_agents.edit',
            'custom_agents.create',
            'custom_agents.show',
            'custom_agents.destroy',
        ]);

        $operator = Role::create(['name' => 'Operator']);

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
            'admin.rates.air.index',
            'admin.rates.air.edit',
            'admin.rates.air.show',
            'admin.rates.fcl.index',
            'admin.rates.fcl.edit',
            'admin.rates.fcl.show',
            'admin.rates.lcl.index',
            'admin.rates.lcl.edit',
            'admin.rates.lcl.show',
            'admin.rates.local_transport.index',
            'admin.rates.local_transport.edit',
            'admin.rates.local_transport.show',
            'admin.customs_exchange_rates.index',
            'admin.customs_exchange_rates.edit',
            'admin.customs_exchange_rates.show',
            'admin.customs_exchange_rates.create',
            'admin.freight_quotes.index',
            'admin.freight_quotes.edit',
            'admin.freight_quotes.show',
        ]);

        $business_executive = Role::create(['name' => 'BusinessExecutive']);

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
            'admin.customs_exchange_rates.index',
            'admin.customs_exchange_rates.show',
            'admin.freight_quotes.index',
            'admin.freight_quotes.show',
        ]);


        //User Admin
        $user = User::find(1); 
        $user->assignRole('Admin');

        //User Client
        $client = User::find(2); 
        $client->assignRole('Cliente');

         //User Operator
         $user = User::find(3); 
         $user->assignRole('Operator');
 
         //User Business_executive
         $user = User::find(4); 
         $user->assignRole('BusinessExecutive');
 
         //User BusinessExecutive
         $user = User::find(5); 
         $user->assignRole('BusinessExecutive');

    }
}
