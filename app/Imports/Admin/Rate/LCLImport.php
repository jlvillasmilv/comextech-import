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
    public function model(array $row)
    {
        return new RateLcl([
            'user_id'       => auth()->user()->id,
            'from'          => $rows['from'],
            'to'            => $rows['to'],
            'via'           => $rows['via'],
            't_time'        => $rows['t_time'],
            'currency'      => $rows['currency'],
            'valid_from'    => date("Y-m-d", strtotime($rows['valid_from'])),
            'valid_to'      => date("Y-m-d", strtotime($rows['valid_to'])),
            'MIN_0_5'       => $rows['MIN_0_5'],
            'w0_5_TON_M3'   => $rows['w0_5_TON_M3'],
            'MIN_5_10'      => $rows['MIN_5_10'],
            'w5_10_TON_M3'  => $rows['w5_10_TON_M3'],
            'MIN_10_5'      => $rows['MIN_10_5'],
            'w10_15_TON_M3' => $rows['w10_15_TON_M3'],
            'oth_exp'       => $rows['gl'],
        ]);
    }
}









