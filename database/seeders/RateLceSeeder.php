<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RateLceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('rate_lce')
            ->insert([
                ['user_id'   => 1,'trans_company_id' => '2', 'initial'  => 0, 'limit'  => 29.99,'rate'  => 20],
                ['user_id'   => 1,'trans_company_id' => '2', 'initial'  => 30, 'limit'  => 49.99,'rate'  => 20],
                ['user_id'   => 1,'trans_company_id' => '2', 'initial'  => 50, 'limit'  => 69.99,'rate'  => 20],
                ['user_id'   => 1,'trans_company_id' => '2', 'initial'  => 70, 'limit'  => 99.99,'rate'  => 20],
                ['user_id'   => 1,'trans_company_id' => '2', 'initial'  => 100, 'limit'  => 299.99,'rate'  => 20],
                ['user_id'   => 1,'trans_company_id' => '2', 'initial'  => 300, 'limit'  => 399.99,'rate'  => 20],
                ['user_id'   => 1,'trans_company_id' => '2', 'initial'  => 400, 'limit'  => 599.99,'rate'  => 20],
                ['user_id'   => 1,'trans_company_id' => '2', 'initial'  => 600, 'limit'  => 999.99,'rate'  => 20],
                ['user_id'   => 1,'trans_company_id' => '2', 'initial'  => 1000, 'limit'  => 2999.99,'rate'  => 20],
                ['user_id'   => 1,'trans_company_id' => '2', 'initial'  => 3000, 'limit'  => 99999.99,'rate'  => 20],

                ['user_id'   => 1,'trans_company_id' => '3', 'initial'  => 0, 'limit'  => 29.99,'rate'  => 20],
                ['user_id'   => 1,'trans_company_id' => '3', 'initial'  => 30, 'limit'  => 49.99,'rate'  => 20],
                ['user_id'   => 1,'trans_company_id' => '3', 'initial'  => 50, 'limit'  => 69.99,'rate'  => 20],
                ['user_id'   => 1,'trans_company_id' => '3', 'initial'  => 70, 'limit'  => 99.99,'rate'  => 20],
                ['user_id'   => 1,'trans_company_id' => '3', 'initial'  => 100, 'limit'  => 299.99,'rate'  => 20],
                ['user_id'   => 1,'trans_company_id' => '3', 'initial'  => 300, 'limit'  => 399.99,'rate'  => 20],
                ['user_id'   => 1,'trans_company_id' => '3', 'initial'  => 400, 'limit'  => 599.99,'rate'  => 20],
                ['user_id'   => 1,'trans_company_id' => '3', 'initial'  => 600, 'limit'  => 999.99,'rate'  => 20],
                ['user_id'   => 1,'trans_company_id' => '3', 'initial'  => 1000, 'limit'  => 2999.99,'rate'  => 20],
                ['user_id'   => 1,'trans_company_id' => '3', 'initial'  => 3000, 'limit'  => 99999.99,'rate'  => 20], 
            ]);
    }
}
