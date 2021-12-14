<?php

namespace App\Imports\Admin\Rate;

use App\Models\RateLcl;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LCLImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $rows)
    {   
       // dd($rows);
        return new RateLcl([
            'user_id'       => auth()->user()->id,
            'from'          => $rows['from'],
            'to'            => $rows['to'],
            'via'           => $rows['via'],
            't_time'        => $rows['t_time'],
            'currency'      => $rows['currency'],
            'valid_from'    => date("Y-m-d", $rows['valid_from']),
            'valid_to'      => date("Y-m-d", $rows['valid_to']),
            'MIN_0_5'       => $rows['min_0_5'],
            'w0_5_TON_M3'   => $rows['w0_5_ton_m3'],
            'MIN_5_10'      => $rows['min_5_10'],
            'w5_10_TON_M3'  => $rows['w5_10_ton_m3'],
            'MIN_10_5'      => $rows['min_10_5'],
            'w10_15_TON_M3' => $rows['w10_15_ton_m3'],
            'oth_exp'       => is_null($rows['gl']) ? 0 : $rows['gl'],
        ]);
    }
}









