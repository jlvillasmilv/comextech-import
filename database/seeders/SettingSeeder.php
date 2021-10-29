<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('settings')->insert([
            'name'       => 'COMEXTECH',
            'rate'       => 1.50,
            'mora_rate'  => 3.50,
            'discount'   => 95,
            'commission' => 40000,
            'api_sii'    => 'https://api.libredte.cl/api/v1/sii/rcv/ventas/detalle',
            'token_sii'  => "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNzczZGUxMjQyYzgwNDAwNjViYWZkYmVlZmMyZmQwNzMwZjZiYjY2NTZkYWMzOTNmZjdlODY0OGQ1NTA3ZWQ2YmFmMzUyODQzZmU0NTcyMjgiLCJpYXQiOjE2MTYxNzg5MzksIm5iZiI6MTYxNjE3ODkzOSwiZXhwIjoxNjQ3NzE0OTM5LCJzdWIiOiI1NTUiLCJzY29wZXMiOltdfQ.fNZtQz4E0Eib5JUnDnzr1YJMmAqCERWl98Z2fx2BIqS3Lwr4jdEfl0uxe0RQQk_N665t6ROGPrX3vJSPe6KO2pAuGHOqMjZh75Tv2OHT_7gZNfUWJOo_ztU4c739Uy5bClLOK8NV58_I42swLBR0N3HuEE93o2Kv_9rCZuPF_RL4JVPVCtdUBEQROeJoGe_ND_GcIzXgcXhoKRiDccTaH2gnhh6XVUvauTpdzEsoqHfSOz-ptvLwihaPsiwTW_t3czuftKPq3UKbw6g72FOkVtnWhogJ7VHgJ5KKNAfP1HoKwe3IoDZN3GcWlOlpw_cj26YnBQWOR4udpNomZ71j0p4mkC86XMzdDiZj5qSM6M5RdH-yvpi8AxH7bkJyTAE3gaBAxCUk7br8Z6ioX90X0fDTUWhcn7vNuWYGyu7ncyXPuYFKVzh4jS08HL8goSBn25heUxG__Lp6y-HFbp-wKTC9V42TLj5iE0wewbnVTNTPE4VGsvieU_v1TKEzIrX3ABUNsjRukWAxUoNURQPDbkKVnVTzElYdslYfux5OwWb_L8aXCJSS3ggdEemJ529cW5Xd6bKsVKtwHfyDBdO7LRIU2kLlbK2lZScQH55B8bk2J13gF1si9AEmrZnFBbRpnU0KSri3aFndpja2qHhy7pmZIs9v3JeMPzYoMtalFfw",
            'created_at' => now(),
        ]);
    }
}
