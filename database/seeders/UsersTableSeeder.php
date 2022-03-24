<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Company, User, TransCompany, Supplier};
use App\Models\Team;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $user = User::create([
            'name'      => 'Admin',
            'email'     => 'admin@admin.com',
            'email_verified_at' => now(),
            'password'  => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $company = Company::create([
            'country_id' => \DB::table('countries')->where('code','CL')->first()->id,
            'tax_id'  => '77277994-1',
            'name'    => 'FORZA INTERNATIONAL BUSINESS GROUP SPA',
            'email'   => 'info@Comex.Tech',
            'phone'   => '+56228977070',
            'contact_name'   => 'Andres Fabregat',
            'status'  => 1
        ]);

         $client = User::create([
            'company_id' =>  $company->id,
            'name'       => 'Andres',
            'email'      => 'andres@fabregat.cl',
            'email_verified_at' => now(),
            'phone'      => '+56991395040',
            'password'   => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $client->jumpSellerUser()->create([
            'customer_id' => 7004968
        ]);

        $client->ports()->sync([13,14]);


        $supplier = Supplier::create([
            'user_id' => $client->id,
            'name'   => 'Ollie Hirthe PhD',
            'address'=> '71505 Dario Mills Suite 374 West Jalon, MI 69608',
            'bank'   => 'oberbrunner',
            'isin'   => '766174',
            'iban'   => '30645647484',
            'phone'  => '481-853-6595 x30822',
            'email'  => 'haley.easton@example.org',
        ]);

        $supplier->supplierAddress()->create([
            'place'             => 'FABRICA',
            'latitude'          =>  35.1208505,
            'longitude'         => -90.070634,
            'postal_code'       => '38106',
            'locality'          => 'Memphis',
            'country_code'      => 'US',
            'address'           => '401 Stark Ramp Nienowland, MT 57331'
        ]);

        $supplier->ports()->sync([26,25]);

       $trans_company  = TransCompany::get();

       foreach ($trans_company as $key => $company) {
        $client->discount()->create([
            'trans_company_id' => $company->id,
            'imp_a' => 60
        ]);
       }

       \DB::table('user_mark_ups')->insert([
        'user_id' => $client->id,
        ]);

       $client->credential()->create([
            'provider_name' => 'SII',
            'provider_password' => base64_encode('FO2022RZA'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        \DB::table('company_addresses')->insert([
            [ 'company_id'  => 1,
              'country_id'  => \DB::table('countries')->where('code','CL')->first()->id,
              'province'    => 'Santiago',
              'postal_code' => '7550214',
              'locality'    => 'Las Condes',
              'place'       => 'ALMACEN',
              'address'     => 'Augusto Leguía Sur 79, Of. 1110, Las Condes, Región Metropolitana, Chile',
              'latitude'    => -33.418089046025656,
              'longitude'   => -70.5969086286471,
            ],
        ]);

        $client->ownedTeams()->save(Team::forceCreate([
            'user_id' => $client->id,
            'name' => explode(' ', $client->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));

        $operator = User::create([
            'name'      => 'Operador',
            'email'     => 'operator@operator.com',
            'email_verified_at' => now(),
            'password'  => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $executive = User::create([
            'name'      => 'Business 1',
            'email'     => 'executive1@executive.com',
            'email_verified_at' => now(),
            'phone'     => '584247005888',
            'password'  => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $executive = User::create([
            'name'      => 'Business 2',
            'email'     => 'executive2@executive.com',
            'email_verified_at'  => now(),
            'phone'     => '584247005888',
            'password'  => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

    }
}
