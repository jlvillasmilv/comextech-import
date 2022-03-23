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
            'token_sii'  => "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiNDE5ZDIyNWZiYjkzNGIyMWM4NzdmZDBlNTNjODNiMDZkYTIxODFkMTNiYmFiZjBjZTY5MzgzMTRjYWE0YTg0YmE5NDM3YTFiYjlmMTRiODgiLCJpYXQiOjE2NDc5ODU5MTEsIm5iZiI6MTY0Nzk4NTkxMSwiZXhwIjo0ODAzNjU5NTExLCJzdWIiOiI1NTUiLCJzY29wZXMiOltdfQ.fWqjsrOid3b8UZQ9nARsJsGjGSNU4xbd96tBbICTxh1k6afoiGKRB4ehpx2V_tOeeJY8xbFu8a6UhYNNwhGGvyNSpSMs_EUyMVdUhx8b4H1dKzVOBoK8vkDnYf4sDkbEhHWWai3yfi9o00m3ysbMD1TortU8pZCDuP4MJSQfi7Riqj6RAU_BlMKOVvXQgXyttqeQHcvLDfl6d-fkjVpo30JqMVTT4RofkpulmrpQxe0a-QD218xAOhIwbQcmqMoEu2SfixKyX0fkNIdHE8M8-aIhMou2mqraN4QqtG57pKxRTbqKQvOjmDp8LkIRI7HM1MUeWhI_jFSTX8nUPeIRYoN3dMer0a8bmoEh78nSdCgHhgUF6veFwWntuMx5gIZopI7TcmI3v3nvryOxlgY2PYNra1ZPqhMpHflF_MiZz-tRj8jZzgBjEYboubvBg7FEVIDsRm8CdZM8Gzgpq4YaTsa3qJIzNx5C1cs22NfHipVnoTMMF-YO1p7iahjhfhTMfs8UQD-xPh3wr6GFbRPC9kbuQNTNWCEchPM8oLHYs1sTFMSmnQDTYAx_4tKxjp2oQejZo0TAyU9XDdesnXISeRjdkwHFqMPme2vl7BryhF23fAM-aBRAg_T9Lge_jZbUGXcfHGDyU6_Y-ShuflouQbt780Jki6-9rDUSlJtM-4g",
            'created_at' => now(),
        ]);
    }
}
