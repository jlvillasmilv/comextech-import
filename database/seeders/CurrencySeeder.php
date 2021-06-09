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
            ['code' =>'ALL',  'name' => 'Albania Leke', 'symbol' => 'Lek'],
            ['code' =>'AFN',  'name' => 'Afghanistan Afghanis', 'symbol' => '؋'],
            ['code' =>'ARS',  'name' => 'Argentina Pesos', 'symbol' => '$'],
            ['code' =>'AWG',  'name' => 'Aruba Guilders', 'symbol' => 'ƒ'],
            ['code' =>'AUD',  'name' => 'Australia Dollars', 'symbol' => '$'],
            ['code' =>'AZN',  'name' => 'Azerbaijan New Manats', 'symbol' => 'ман'],
            ['code' =>'BSD',  'name' => 'Bahamas Dollars', 'symbol' => '$'],
            ['code' =>'BBD',  'name' => 'Barbados Dollars', 'symbol' => '$'],
            ['code' =>'BYR',  'name' => 'Belarus Rubles', 'symbol' => 'p.'],
            ['code' =>'BZD',  'name' => 'Beliz Dollars', 'symbol' => 'BZ$'],
            ['code' =>'BMD',  'name' => 'Bermuda Dollars', 'symbol' => '$'],
            ['code' =>'BOB',  'name' => 'Bolivia Bolivianos', 'symbol' => '$b'],
            ['code' =>'BAM',  'name' => 'Bosnia and Herzegovina Convertible Marka', 'symbol' => 'KM'],
            ['code' =>'BWP',  'name' => 'Botswana Pula', 'symbol' => 'P'],
            ['code' =>'BGN',  'name' => 'Bulgaria Leva', 'symbol' => 'лв'],
            ['code' =>'BRL',  'name' => 'Brazil Reais', 'symbol' => 'R$'],
            ['code' =>'GBP',  'name' => 'United Kingdom Pounds', 'symbol' => '£'],
            ['code' =>'BND',  'name' => 'Brunei Darussalam Dollars', 'symbol' => '$'],
            ['code' =>'KHR',  'name' => 'Cambodia Riels', 'symbol' => '៛'],
            ['code' =>'CAD',  'name' => 'Canada Dollars', 'symbol' => '$'],
            ['code' =>'KYD',  'name' => 'Cayman Islands Dollars', 'symbol' => '$'],
            ['code' =>'CLP',  'name' => 'Chile Pesos', 'symbol' => '$'],
            ['code' =>'CNY',  'name' => 'China Yuan Renminbi', 'symbol' => '¥'],
            ['code' =>'COP',  'name' => 'Colombia Pesos', 'symbol' => '$'],
            ['code' =>'CRC',  'name' => 'Costa Rica Colón', 'symbol' => '₡'],
            ['code' =>'HRK',  'name' => 'Croatia Kuna', 'symbol' => 'kn'],
            ['code' =>'CUP',  'name' => 'Cuba Pesos', 'symbol' => '₱'],
            ['code' =>'CZK',  'name' => 'Czech Republic Koruny', 'symbol' => 'Kč'],
            ['code' =>'DKK',  'name' => 'Denmark Kroner', 'symbol' => 'kr'],
            ['code' =>'DOP ', 'name' => 'Dominican Republic Pesos', 'symbol' => 'RD$'],
            ['code' =>'XCD',  'name' => 'East Caribbean Dollars', 'symbol' => '$'],
            ['code' =>'EGP',  'name' => 'Egypt Pounds', 'symbol' => '£'],
            ['code' =>'SVC',  'name' => 'El Salvador Colones', 'symbol' => '$'],
            ['code' =>'EUR',  'name' => 'Euro', 'symbol' => '€'],
            ['code' =>'FKP',  'name' => 'Falkland Islands Pounds', 'symbol' => '£'],
            ['code' =>'FJD',  'name' => 'Fiji Dollars', 'symbol' => '$'],
            ['code' =>'GHC',  'name' => 'Ghana Cedis', 'symbol' => '¢'],
            ['code' =>'GIP',  'name' => 'Gibraltar Pounds', 'symbol' => '£'],
            ['code' =>'GTQ',  'name' => 'Guatemala Quetzales', 'symbol' => 'Q'],
            ['code' =>'GGP',  'name' => 'Guernsey Pounds', 'symbol' => '£'],
            ['code' =>'GYD',  'name' => 'Guyana Dollars', 'symbol' => '$'],
            ['code' =>'HNL',  'name' => 'Honduras Lempiras', 'symbol' => 'L'],
            ['code' =>'HKD',  'name' => 'Hong Kong Dollars', 'symbol' => '$'],
            ['code' =>'HUF',  'name' => 'Hungary Forint', 'symbol' => 'Ft'],
            ['code' =>'ISK',  'name' => 'Iceland Kronur', 'symbol' => 'kr'],
            ['code' =>'INR',  'name' => 'India Rupees', 'symbol' => 'Rp'],
            ['code' =>'IDR',  'name' => 'Indonesia Rupiahs', 'symbol' => 'Rp'],
            ['code' =>'IRR',  'name' => 'Iran Rials', 'symbol' => '﷼'],
            ['code' =>'IMP',  'name' => 'Isle of Man Pounds', 'symbol' => '£'],
            ['code' =>'ILS',  'name' => 'Israel New Shekels', 'symbol' => '₪'],
            ['code' =>'JMD',  'name' => 'Jamaica Dollars', 'symbol' => 'J$'],
            ['code' =>'JPY',  'name' => 'Japan Yen', 'symbol' => '¥'],
            ['code' =>'JEP',  'name' => 'Jersey Pounds', 'symbol' => '£'],
            ['code' =>'KZT',  'name' => 'Kazakhstan Tenge', 'symbol' => 'лв'],
            ['code' =>'KPW',  'name' => 'Korea (North) Won', 'symbol' => '₩'],
            ['code' =>'KRW',  'name' => 'Korea (South) Won', 'symbol' => '₩'],
            ['code' =>'KGS',  'name' => 'Kyrgyzstan Soms', 'symbol' => 'лв'],
            ['code' =>'LAK',  'name' => 'Laos Kips', 'symbol' => '₭'],
            ['code' =>'LVL',  'name' => 'Latvia Lati', 'symbol' => 'Ls'],
            ['code' =>'LBP',  'name' => 'Lebanon Pounds', 'symbol' => '£'],
            ['code' =>'LRD',  'name' => 'Liberia Dollars', 'symbol' => '$'],
            ['code' =>'LTL',  'name' => 'Lithuania Litai', 'symbol' => 'Lt'],
            ['code' =>'MKD',  'name' => 'Macedonia Denars', 'symbol' => 'ден'],
            ['code' =>'MYR',  'name' => 'Malaysia Ringgits', 'symbol' => 'RM'],
            ['code' =>'MUR',  'name' => 'Mauritius Rupees', 'symbol' => '₨'],
            ['code' =>'MXN',  'name' => 'Mexico Pesos', 'symbol' => '$'],
            ['code' =>'MNT',  'name' => 'Mongolia Tugriks', 'symbol' => '₮'],
            ['code' =>'MZN',  'name' => 'Mozambique Meticais', 'symbol' => 'MT'],
            ['code' =>'NAD',  'name' => 'Namibia Dollars', 'symbol' => '$'],
            ['code' =>'NPR',  'name' => 'Nepal Rupees', 'symbol' => '₨'],
            ['code' =>'ANG',  'name' => 'Netherlands Antilles Guilders', 'symbol' => 'ƒ'],
            ['code' =>'NZD',  'name' => 'New Zealand Dollars', 'symbol' => '$'],
            ['code' =>'NIO',  'name' => 'Nicaragua Cordobas', 'symbol' => 'C$'],
            ['code' =>'NGN',  'name' => 'Nigeria Nairas', 'symbol' => '₦'],
            ['code' =>'NOK',  'name' => 'Norway Krone', 'symbol' => 'kr'],
            ['code' =>'OMR',  'name' => 'Oman Rials', 'symbol' => '﷼'],
            ['code' =>'PKR',  'name' => 'Pakistan Rupees', 'symbol' => '₨'],
            ['code' =>'PAB',  'name' => 'Panama Balboa', 'symbol' => 'B/.'],
            ['code' =>'PYG',  'name' => 'Paraguay Guarani', 'symbol' => 'Gs'],
            ['code' =>'PEN',  'name' => 'Peru Nuevos Soles', 'symbol' => 'S/.'],
            ['code' =>'PHP',  'name' => 'Philippines Pesos', 'symbol' => 'Php'],
            ['code' =>'PLN',  'name' => 'Poland Zlotych', 'symbol' => 'zł'],
            ['code' =>'QAR',  'name' => 'Qatar Rials', 'symbol' => '﷼'],
            ['code' =>'RON',  'name' => 'Romania New Lei', 'symbol' => 'lei'],
            ['code' =>'RUB',  'name' => 'Russia Rubles', 'symbol' => 'руб'],
            ['code' =>'SHP',  'name' => 'Saint Helena Pounds', 'symbol' => '£'],
            ['code' =>'SAR',  'name' => 'Saudi Arabia Riyals', 'symbol' => '﷼'],
            ['code' =>'RSD',  'name' => 'Serbia Dinars', 'symbol' => 'Дин.'],
            ['code' =>'SCR',  'name' => 'Seychelles Rupees', 'symbol' => '₨'],
            ['code' =>'SGD',  'name' => 'Singapore Dollars', 'symbol' => '$'],
            ['code' =>'SBD',  'name' => 'Solomon Islands Dollars', 'symbol' => '$'],
            ['code' =>'SOS',  'name' => 'Somalia Shillings', 'symbol' => 'S'],
            ['code' =>'ZAR',  'name' => 'South Africa Rand', 'symbol' => 'R'],
            ['code' =>'LKR',  'name' => 'Sri Lanka Rupees', 'symbol' => '₨'],
            ['code' =>'SEK',  'name' => 'Sweden Kronor', 'symbol' => 'kr'],
            ['code' =>'CHF',  'name' => 'Switzerland Francs', 'symbol' => 'CHF'],
            ['code' =>'SRD',  'name' => 'Suriname Dollars', 'symbol' => '$'],
            ['code' =>'SYP',  'name' => 'Syria Pounds', 'symbol' => '£'],
            ['code' =>'TWD',  'name' => 'Taiwan New Dollars', 'symbol' => 'NT$'],
            ['code' =>'THB',  'name' => 'Thailand Baht', 'symbol' => '฿'],
            ['code' =>'TTD',  'name' => 'Trinidad and Tobago Dollars', 'symbol' => 'TT$'],
            ['code' =>'TRY',  'name' => 'Turkey Lira', 'symbol' => 'TL'],
            ['code' =>'TRL',  'name' => 'Turkey Liras', 'symbol' => '£'],
            ['code' =>'TVD',  'name' => 'Tuvalu Dollars', 'symbol' => '$'],
            ['code' =>'UAH',  'name' => 'Ukraine Hryvnia', 'symbol' => '₴'],
            ['code' =>'USD',  'name' => 'United States of America Dollars', 'symbol' => '$'],
            ['code' =>'UYU',  'name' => 'Uruguay Pesos', 'symbol' => '$U'],
            ['code' =>'UZS',  'name' => 'Uzbekistan Sums', 'symbol' => 'лв'],
            ['code' =>'VEF',  'name' => 'Venezuela Bolivares Fuertes', 'symbol' => 'Bs'],
            ['code' =>'VND',  'name' => 'Vietnam Dong', 'symbol' => '₫'],
            ['code' =>'YER',  'name' => 'Yemen Rials', 'symbol' => '﷼'],
            ['code' =>'ZWD',  'name' => 'Zimbabwe Zimbabwe Dollars', 'symbol' => 'Z$'],
        ]);
    }
}
