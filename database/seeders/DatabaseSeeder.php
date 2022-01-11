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
        $this->call(RateTransportSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(SeaPortSeeder::class);
        $this->call(TransCompaniesSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(CustomsExchangeRateSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(ApplicationStatusSeeder::class);
        $this->call(CategoryServiceSeeder::class);
        $this->call(TransportModeSeeder::class);
        $this->call(CategoryLoadSeeder::class);
        $this->call(CategoryContainerSeeder::class);
        $this->call(ApplicationSeeder::class);
        $this->call(WarehouseSeeder::class);
        $this->call(SupplCondSaleSeeder::class);
        $this->call(CustomAgentSeeder::class);
        $this->call(EcommerceSeeder::class);
        $this->call(FactoringSeeder::class);
        $this->call(RateLceSeeder::class);
    }
}
