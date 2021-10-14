<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
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

      $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));


        $client = User::create([
            'name'      => 'Cliente',
            'email'     => 'client@client.com',
            'email_verified_at' => now(),
            'password'  => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        $client->company()->create([
            'country_id' => 6,
            'tax_id'  => '76722268-8',
            'name'    => 'Comextech',
            'email'   => 'info@Comex.Tech',
            'phone'   => '+56228977070',
            'contact_name'   => 'Andres Fabregat',
            'status'  => 1
        ]);

        $client->discount()->create([
            'imp_a' => 60
        ]);

        \DB::table('company_addresses')->insert([
            [ 'company_id'  => '1',
              'country_id'  => '41',
              'postal_code' => '7550214',
              'locality'    => 'Las Condes',
              'place'       => 'ALMACEN',
              'address'     => 'Augusto Leguía Sur 79, Of. 1110, Las Condes, Región Metropolitana, Chile'
            ],
        ]);

        $client->ownedTeams()->save(Team::forceCreate([
            'user_id' => $client->id,
            'name' => explode(' ', $client->name, 2)[0]."'s Team",
            'personal_team' => true,
        ]));

        

    }
}
