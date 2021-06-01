<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         if (\DB::table('currencies')->count() > 0) {
            return;
        }

        \DB::table('currencies')->insert([
            ['code' =>'ARS' , 'name' => 'Argentine Peso', 'symbol' => '$' ],
            ['code' =>'AUD' , 'name' => 'Australian Dollar', 'symbol' => '$' ],
            ['code' =>'AWG' , 'name' => 'Aruban Guilder', 'symbol' => 'ƒ' ],
            ['code' =>'BRL' , 'name' => 'Brazilian Real', 'symbol' => 'R$' ],
            ['code' =>'CAD' , 'name' => 'Canadian Dollar', 'symbol' => '$' ],
            ['code' =>'CHF' , 'name' => 'Swiss Franc', 'symbol' => 'CHF' ],
            ['code' =>'CLP' , 'name' => 'Peso Chileno', 'symbol' => '$' ],
            ['code' =>'CNY' , 'name' => 'Yuan Renminbi', 'symbol' => '¥' ],
            ['code' =>'COP' , 'name' => 'COU Colombian Peso Unidad de Valor Real', 'symbol' => '$' ],
            ['code' =>'CRC' , 'name' => 'Costa Rican Colon', 'symbol' => '₡' ],
            ['code' =>'EUR' , 'name' => 'Euro', 'symbol' => '€' ],
            ['code' =>'GBP' , 'name' => 'Pound Sterling', 'symbol' => '£' ],
            ['code' =>'HKD' , 'name' => 'Hong Kong Dollar', 'symbol' => '$' ],
            ['code' =>'ISK' , 'name' => 'Iceland Krona', 'symbol' => 'kr' ],
            ['code' =>'JPY' , 'name' => 'Yen', 'symbol' => '¥' ],
            ['code' =>'KGS' , 'name' => 'Som', 'symbol' => 'лв' ],
            ['code' =>'KHR' , 'name' => 'Riel', 'symbol' => '៛' ],
            ['code' =>'LBP' , 'name' => 'Lebanese Pound', 'symbol' => '£' ],
            ['code' =>'MNT' , 'name' => 'Tugrik', 'symbol' => '₮' ],
            ['code' =>'MUR' , 'name' => 'Mauritius Rupee', 'symbol' => '₨' ],
            ['code' =>'MXN' , 'name' => 'MXV Mexican Peso Mexican Unidad de Inversion (UDI]', 'symbol' => '$' ],
            ['code' =>'MYR' , 'name' => 'Malaysian Ringgit', 'symbol' => 'RM' ],
            ['code' =>'MZN' , 'name' => 'Metical', 'symbol' => 'MT' ],
            ['code' =>'NIO' , 'name' => 'Cordoba Oro', 'symbol' => 'C$' ],
            ['code' =>'RUB' , 'name' => 'Russian Ruble', 'symbol' => 'руб' ],
            ['code' =>'SAR' , 'name' => 'Saudi Riyal', 'symbol' => '﷼' ],
            ['code' =>'USD' , 'name' => 'US Dollar', 'symbol' => '$' ],
            ['code' =>'UYU' , 'name' => 'UYI Uruguay Peso en Unidades Indexadas', 'symbol' => '$U' ],
            ['code' =>'VEF' , 'name' => 'Bolivar Fuerte', 'symbol' => 'Bs' ],
        ]);
    }
}
