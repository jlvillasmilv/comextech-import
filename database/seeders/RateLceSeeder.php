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
                ['user_id'   => 1,'trans_company_id' => '2', 'val_init'  => 0, 'val_limit'  => 29.99,'rate'  => 20],
                ['user_id'   => 1,'trans_company_id' => '2', 'val_init'  => 30, 'val_limit'  => 49.99,'rate'  => 34.88],
                ['user_id'   => 1,'trans_company_id' => '2', 'val_init'  => 50, 'val_limit'  => 69.99,'rate'  => 48.35],
                ['user_id'   => 1,'trans_company_id' => '2', 'val_init'  => 70, 'val_limit'  => 99.99,'rate'  => 55.43],
                ['user_id'   => 1,'trans_company_id' => '2', 'val_init'  => 100, 'val_limit'  => 299.99,'rate'  => 70.60],
                ['user_id'   => 1,'trans_company_id' => '2', 'val_init'  => 300, 'val_limit'  => 399.99,'rate'  => 95.81],
                ['user_id'   => 1,'trans_company_id' => '2', 'val_init'  => 400, 'val_limit'  => 599.99,'rate'  => 110.58],
                ['user_id'   => 1,'trans_company_id' => '2', 'val_init'  => 600, 'val_limit'  => 999.99,'rate'  => 120.20],
                ['user_id'   => 1,'trans_company_id' => '2', 'val_init'  => 1000, 'val_limit'  => 2999.99,'rate'  => 161.72],
                ['user_id'   => 1,'trans_company_id' => '2', 'val_init'  => 3000, 'val_limit'  => 999999.99,'rate'  => 175],

                ['user_id'   => 1,'trans_company_id' => '3', 'val_init'  => 0, 'val_limit'  => 29.99,'rate'  => 20],
                ['user_id'   => 1,'trans_company_id' => '3', 'val_init'  => 30, 'val_limit'  => 49.99,'rate'  => 34.88],
                ['user_id'   => 1,'trans_company_id' => '3', 'val_init'  => 50, 'val_limit'  => 69.99,'rate'  => 48.35],
                ['user_id'   => 1,'trans_company_id' => '3', 'val_init'  => 70, 'val_limit'  => 99.99,'rate'  => 55.43],
                ['user_id'   => 1,'trans_company_id' => '3', 'val_init'  => 100, 'val_limit'  => 299.99,'rate'  => 70.60],
                ['user_id'   => 1,'trans_company_id' => '3', 'val_init'  => 300, 'val_limit'  => 399.99,'rate'  => 95.81],
                ['user_id'   => 1,'trans_company_id' => '3', 'val_init'  => 400, 'val_limit'  => 599.99,'rate'  => 110.58],
                ['user_id'   => 1,'trans_company_id' => '3', 'val_init'  => 600, 'val_limit'  => 999.99,'rate'  => 120.20],
                ['user_id'   => 1,'trans_company_id' => '3', 'val_init'  => 1000, 'val_limit'  => 2999.99,'rate'  => 161.72],
                ['user_id'   => 1,'trans_company_id' => '3', 'val_init'  => 3000, 'val_limit'  => 999999.99,'rate'  => 175],
            ]);
    }
}
