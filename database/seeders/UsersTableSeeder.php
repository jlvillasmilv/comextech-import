<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Company, User, TransCompany, Supplier, JumpSellerUser};
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

         
        $user->assignRole('Admin');

        $company = Company::create([
            'country_id' => \DB::table('countries')->where('code','CL')->first()->id,
            'tax_id'  => '77277994-1',
            'name'    => 'FORZA INTERNATIONAL BUSINESS GROUP SPA',
            'email'   => 'info@Comex.Tech',
            'phone'   => '+56228977070',
            'contact_name'   => 'Andres Fabregat'
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

        $client->assignRole('Cliente');

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

        $operator->assignRole('Operator');

        $executive = User::create([
            'name'      => 'Business 1',
            'email'     => 'executive1@executive.com',
            'email_verified_at' => now(),
            'phone'     => '584247005888',
            'password'  => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

 
        $executive->assignRole('BusinessExecutive');
 
        $executive = User::create([
            'name'      => 'Business 2',
            'email'     => 'executive2@executive.com',
            'email_verified_at'  => now(),
            'phone'     => '584247005888',
            'password'  => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $executive->assignRole('BusinessExecutive');


        $users_new = [
            [ 'user_name' => 'PIA MADARO', 'email' => 'PIA.MADARO@COMTEC.CL', 'password' => '78847150',  'tax_id' => '78.847.150-5', 'company_name'  => 'Comercial Comtec Ltda' ],
            [ 'user_name' => 'ALVARO SOTOMAYOR', 'email' => 'ALVAROSOTOMAYOR@GEBRAX.COM', 'password' => '76078271',  'tax_id' => '76.078.271-8', 'company_name'  => 'Gebrax Y Cia Ltda' ],
            [ 'user_name' => 'PATRICIA GALARCE LATORRE', 'email' => 'PATRICIA@HBOSAANS.CL', 'password' => '78859900',  'tax_id' => '78.859.900-5', 'company_name'  => 'H Bosaans Y Cia' ],
            [ 'user_name' => 'CECILIA SANZ QUINTEROS', 'email' => 'CECILIA.SANZ.Q@GMAIL.COM', 'password' => '77132928',  'tax_id' => '77.132.928-4', 'company_name'  => 'Msq Spa' ],
            [ 'user_name' => 'MARIA JOSÉ CAMPOS', 'email' => 'INFO@OVERDRIVE.CL', 'password' => '15371041',  'tax_id' => '15.371.041-4', 'company_name'  => 'Rodrigo Garcia Gonzalez' ],
            [ 'user_name' => 'DIEGO SCHURTER', 'email' => 'DSCHURTER8@GMAIL.COM', 'password' => '76777407',  'tax_id' => '76.777.407-9', 'company_name'  => 'Ryd Soluciones AgrÍcolas Limitada' ],
            [ 'user_name' => 'JUAN FRANCISCO ESCOBEDO', 'email' => 'kiko@sqbiduu.com', 'password' => '96953530',  'tax_id' => '96.953.530-0', 'company_name'  => 'Sqbiduu Spa' ],
            [ 'user_name' => 'FRANCISCI VIO', 'email' => 'FRANCISCOVIO@GMAIL.COM', 'password' => '76550166',  'tax_id' => '76.550.166-0', 'company_name'  => 'Consultoria Agricola Rural Limitada' ],
            [ 'user_name' => 'FRANCISCO ESTEBAN', 'email' => 'FEV@DIITCHILE.CL', 'password' => '96937830',  'tax_id' => '96.937.830-2', 'company_name'  => 'Diit Chile S.a.' ],
            [ 'user_name' => 'JULIO OLAVE', 'email' => 'OLAVE.MALDONADO@GMAIL.COM', 'password' => '77277994',  'tax_id' => '77.277.994-1', 'company_name'  => 'Forza International Business Group Spa' ],
            [ 'user_name' => 'ARTURO NIETO', 'email' => 'ASISTENTE.CONTABLE2@RPICHILE.CL', 'password' => '76351559',  'tax_id' => '76.351.559-1', 'company_name'  => 'Rpi Productos Industriales S.a.' ],
            [ 'user_name' => 'PATRICIO VIDAL', 'email' => 'PVIDAL@ROBORIS.CL', 'password' => '77972170',  'tax_id' => '77.972.170-1', 'company_name'  => 'Importadora Y Consultora Roboris Limitada' ],
            [ 'user_name' => 'ANDRÉS TORRES', 'email' => 'ANDRES.TORRES@AMADOM.CL', 'password' => '76996567',  'tax_id' => '76.996.567-K', 'company_name'  => 'Amadom Spa' ],
            [ 'user_name' => 'Atilio Ojeda Arrieta', 'email' => 'aojeda@caribeanpharma.cl', 'password' => '76830090',  'tax_id' => '76.830.090-9', 'company_name'  => 'Farmaceutica Caribean Ltda' ],
            [ 'user_name' => 'SEBASTIAN MARTINEZ', 'email' => 'S.MARTINEZ@DARDO3.CL', 'password' => '77153659',  'tax_id' => '77.153.659-K', 'company_name'  => 'Dardo 3 Limitada' ],
            [ 'user_name' => 'SEBASTIAN ATALA', 'email' => 'SEBASTIAN.ATALA@XECUOIA.COM', 'password' => '76438573',  'tax_id' => '76.438.573-K', 'company_name'  => 'Xecuoia Spa' ],
            [ 'user_name' => 'LAURA VALENZUELA', 'email' => 'CONTACTO@CAFEDELBEDUINO.CL', 'password' => '77293326',  'tax_id' => '77.293.326-6', 'company_name'  => 'Comercial Valenzuela Y Recabarren Limitada' ],
            [ 'user_name' => 'ROBERTO ABUSLEME', 'email' => 'GERENCIA@CHALLATIN.CL', 'password' => '76089990',  'tax_id' => '76.089.990-9', 'company_name'  => 'Importadora Abutex Limitada' ],
            [ 'user_name' => 'JULIO OLAVE', 'email' => 'JULIO@FORZA.INTERNATIONAL', 'password' => '77397219',  'tax_id' => '77.397.219-2', 'company_name'  => 'Forza Business Group Spa' ],
            [ 'user_name' => 'JUAN CARLOS GONZALEZ ALARCON', 'email' => 'JCGONZALEZA@IMERLAB.CL', 'password' => '76079592',  'tax_id' => '76.079.592-5', 'company_name'  => 'Imerlab Sociedad Comercial Limitada' ],
            [ 'user_name' => 'ANGEL PEZO', 'email' => 'ANGEL@4TRADE.CL', 'password' => '77184194',  'tax_id' => '77.184.194-5', 'company_name'  => '4trade Spa' ],
            [ 'user_name' => 'MARCELO FABREGAT', 'email' => 'MARCELOFABREGAT@GMAIL.COM', 'password' => '76949906',  'tax_id' => '76.949.906-7', 'company_name'  => 'Comercializadora Fabregat Fleischmann Spa' ],
            [ 'user_name' => 'FERNANDO GUTIERREZ', 'email' => 'FERMELLER2228@GMAIL.COM', 'password' => '77251887',  'tax_id' => '77.251.887-0', 'company_name'  => 'Importadora Sinoparts Spa' ],
            [ 'user_name' => 'JAVIER TISI', 'email' => 'JAVIERTISI@GMAIL.COM', 'password' => '13456871',  'tax_id' => '13.456.871-2', 'company_name'  => 'Javier Tisi' ],
            [ 'user_name' => 'JUAN PABLO CASTRO', 'email' => 'JPC@QUINCHO-CO.CL', 'password' => '77376100',  'tax_id' => '77.376.100-0', 'company_name'  => 'Quincho Co Spa' ],
            [ 'user_name' => 'ANA CECILIA MARENTIS', 'email' => 'ana.marentis@electrafk.cl', 'password' => '96896480',  'tax_id' => '96.896.480-1', 'company_name'  => 'Electra Fk S.a' ],
            [ 'user_name' => 'ANGELICA ALVARADO', 'email' => 'AALVARADOK@UFT.EDU', 'password' => '77383836',  'tax_id' => '77.383.836-4', 'company_name'  => 'Comercializadora Ikiba Spa' ],
            [ 'user_name' => 'PAMELA GUERRERO', 'email' => 'PGUERRERO@BEBIDASMC.CL', 'password' => '77209308',  'tax_id' => '77.209.308-K', 'company_name'  => 'Licsa Spa' ],
            [ 'user_name' => 'FELIPE GARCIA', 'email' => 'FELIPE.GARCIA@TECMEDENT.CL', 'password' => '77191449',  'tax_id' => '77.191.449-7', 'company_name'  => 'Comercializadora Tecmedent Spa' ],
            [ 'user_name' => 'IGNACIO ALLENDE', 'email' => 'IGNACIOALLENDE@RILCH.CL', 'password' => '77487569',  'tax_id' => '77.487.569-7', 'company_name'  => 'Rilch Spa' ],
            [ 'user_name' => 'FERNANDO LOPEZ', 'email' => 'FLOPEZDELRIO@AGENCIASM.CL', 'password' => '76123543',  'tax_id' => '76.123.543-5', 'company_name'  => 'Street Machine Corp S.a.' ],
            [ 'user_name' => 'JUAN GRAU', 'email' => 'JGRAU@KNIFESTORE.CL', 'password' => '76960032',  'tax_id' => '76.960.032-9', 'company_name'  => 'Afila Afila Spa.' ],
           // [ 'user_name' => 'JULIO OLAVE', 'email' => 'OLAVE.MALDONADO@GMAIL.COM', 'password' => '76960032',  'tax_id' => '76.960.032-9', 'company_name'  => 'Afila Afila Spa.' ],
            [ 'user_name' => 'MAYLEN ROMERO', 'email' => 'MACRAMEMODERNOCHILE@GMAIL.COM', 'password' => '15967828',  'tax_id' => '15.967.828-8', 'company_name'  => 'Maylen Estefania Romero Caceres' ],
            [ 'user_name' => 'EDUARDO POZO', 'email' => 'VENTAS@PRODUCTOSNUN.COM', 'password' => '76466074',  'tax_id' => '76.466.074-9', 'company_name'  => 'Nun Spa' ],
            [ 'user_name' => 'MARTHA MOVAREC', 'email' => 'VENTAS@ITRS.CA', 'password' => '77346443',  'tax_id' => '77.346.443-K', 'company_name'  => 'ITRS CHILE SPA' ],
            [ 'user_name' => 'Alejandro Escobedo', 'email' => 'aescobedo@agility.cl', 'password' => '15417863',  'tax_id' => '15.417.863-5', 'company_name'  => 'Sqbiduu Spa' ],
            [ 'user_name' => 'Max', 'email' => 'max@fapro.app', 'password' => '77055894',  'tax_id' => '77.055.894-8', 'company_name'  => 'Fapro' ],
            [ 'user_name' => 'Vicente', 'email' => 'vcruz@thesheriff.cl', 'password' => '77388195',  'tax_id' => '77.388.195-2', 'company_name'  => 'The Sheriff SPA' ],
            [ 'user_name' => 'Paulina', 'email' => 'passaparolachi@gmail.com', 'password' => '77388195',  'tax_id' => '77.388.195-2', 'company_name'  => 'The Sheriff SPA' ],
            [ 'user_name' => 'Esteban', 'email' => 'esteban.solari@solber.cl', 'password' => '8713726',  'tax_id' => '8.713.726-0', 'company_name'  => 'Esteban SpA' ],
            [ 'user_name' => 'Juan Carlos ', 'email' => 'jckarbu@gmail.com', 'password' => '14130938',  'tax_id' => '14.130.938-2', 'company_name'  => 'Karbu Spa' ],
            [ 'user_name' => 'Agustin Vecino', 'email' => 'adelacuestaw@gmail.com', 'password' => '9229091',  'tax_id' => '9.229.091-3', 'company_name'  => 'Agustin DLC SpA' ],
            [ 'user_name' => 'Jaime Fabregat', 'email' => 'jaimefabregatdev925@gmail.com', 'password' => '5024234',  'tax_id' => '5.024.234-k', 'company_name'  => 'Pelao Inc SpA' ],
            [ 'user_name' => 'Rainer Grob', 'email' => 'rainer@gerenciafinanzas.cl', 'password' => '8673407',  'tax_id' => '8.673.407-9', 'company_name'  => 'Rainer SpA' ],
           // [ 'user_name' => 'Angel Pezo', 'email' => 'angel@4trade.cl', 'password' => '19508245',  'tax_id' => '19.508.245-6', 'company_name'  => '4Trade' ],
            [ 'user_name' => 'Carlos Riveros', 'email' => 'csriveros@gmail.com', 'password' => '11647778',  'tax_id' => '11.647.778-5', 'company_name'  => 'Gran Cabeza Blanca SpA' ],
            [ 'user_name' => 'Andres Fabregat', 'email' => 'andres.fabregat@comex.tech', 'password' => '13026763',  'tax_id' => '13.026.763-7', 'company_name'  => 'AJAFF SpA' ]
        ];

        foreach ($users_new as $key => $user) {
           
            $company = Company::updateOrCreate(
                [
                    'tax_id'  =>  $user['tax_id'],
                ],
                [
                'country_id' => \DB::table('countries')->where('code','CL')->first()->id,
                'name'    =>  strtoupper($user['company_name']),
                'email'   =>  strtolower($user['email']),
                'phone'   => '+56000000000',
                // 'contact_name'   => $user['user_name']
            ]);
    
             $client = User::create([
                'company_id' => $company->id,
                'name'       => strtoupper($user['user_name']),
                'email'      => $user['email'],
                'email_verified_at' => now(),
                'phone'      => '+56000000000',
                'password'   => $user['password'], // password
                'remember_token' => Str::random(10),
            ]);

            $client->assignRole('Cliente');

            $data = [
                "customer" => [
                    "name"      => strtoupper($user['user_name']),
                    "surname"   => strtoupper($user['user_name']),
                    "email"     => strtolower($user['email']),
                    "phone"     => "+5600000000",
                    "password"  => 'COMEXTECH.'.$user['password'],
                    "status"    => "approved",
                    "billing_addresses" => [
                        [
                             "name"          => strtoupper($user['user_name']),
                             "surname"       => strtoupper($user['user_name']),
                             "address"       => "...",
                             "city"          => "...",
                             "postal"        => "7550214",
                             "country"       => "CL",
                             "region"        => "12",
                             "taxid"         => null,
                             "primary"       => true,
                             "municipality"  => "Las Condes"
                        ]
                    ],
                ]
            ];
    
           $user_jumpseller = JumpSellerUser::createJumpSellerUser($data);
    
           if(isset($user_jumpseller["id"]) || $user_jumpseller["id"] > 0 )
           {
                $client->jumpSellerUser()->create([
                    'customer_id' => $user_jumpseller["id"]
                ]);
           }
        
           $client->ports()->sync([13,14]);
        
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



        }

    }
}
