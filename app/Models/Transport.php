<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transport extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'transports';
    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function application()
    {
        return $this->belongsTo(Application::class,'application_id');
    }

    public function transCompany()
    {
        return $this->belongsTo(TransCompany::class,'trans_company_id');
    }

    public function originPort()
    {
        return $this->belongsTo(Port::class,'origin_port_id');
    }

    public function destPort()
    {
        return $this->belongsTo(Port::class,'dest_port_id');
    }



    /**
     * @author Jorge Villasmil.
     * 
     * evaluate the type of transport and search the database for transport rates (FCL, LCL and AIR)
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
    */
    public static function rateTransport($data)
    {  
        $int_trans = 0;
        $cif = 0;
        $gl  = 0;
        $t_time = 1;

        if(count($data) > 0)
        {
            //Rate FCL
            if($data['type_transport'] == 'CONTAINER')
            {
               
                foreach($data['container'] as $item) {
                    $field = 'c'.$item->container->name;
                    $rate = RateFcl::where([
                        ['status', true],
                        ['from', $data['from']],
                        ['to', $data['to']],
                    ])
                    ->select($field, 'gl', 't_time')
                    ->first();

                    $int_trans += is_null($rate) ? 0 : $rate->$field;
                    $gl        += is_null($rate) ? 0 : $rate->gl;
                    $t_time =  is_null($rate) ? 12 : $rate->gl;
                }

            }

            // Rate LCL
            if($data['type_transport'] == 'CONSOLIDADO')
            {
                dd($data);

            }

            $cif = $int_trans + $data['commodity'];

            if($gl>0){ 
                $exchange = New Currency;
                $gl = $exchange->convertCurrency($gl, 'USD', 'CLP');
            }

            return [
                'int_trans' => $int_trans,
                'gl'        => $gl,
                'cif'       => $cif,
                't_time'    => $t_time,
            ];


        }
    }

}
