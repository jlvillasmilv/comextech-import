<?php

namespace App\Imports\Admin\Rate;

use App\Models\RateFcl;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FCLImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $rows)
    {
        return new RateFcl([
                'user_id'       => auth()->user()->id,
                'from'          => $rows['from'],
                'to'            => $rows['to'],
                'via'           => $rows['via'],
                't_time'        => $rows['t_time'],
                'currency'      => $rows['currency'],
                'valid_from'    => date("Y-m-d", strtotime($rows['valid_from'])),
                'valid_to'      => date("Y-m-d", strtotime($rows['valid_to'])),
                'c20'           => $rows['20'],
                'c40'           => $rows['40'],
                'c40HC'         => $rows['40hc'],
                'c40NOR'        => $rows['40nor'],
                'oth_exp'       => $rows['gl'],
            ]);
    }
}
