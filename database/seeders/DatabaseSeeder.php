<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountrySeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(ApplicationStatusSeeder::class);
        $this->call(CategoryServiceSeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(CompanySeeder::class);
        
    }
}
