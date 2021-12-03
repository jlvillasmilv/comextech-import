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

    public static function rateTransport($data)
    {  
        $int_trans = 0;
        $cif = 0;
        if(count($data) > 0)
        {
            // FCL
            if($data['type_transport'] == 'CONTAINER')
            {

                foreach($data['container'] as $item) {

                    $rate = RateFcl::where([
                        ['status', true],
                        ['from', $data['from']],
                        ['to', $data['to']],
                    ])
                    ->sum('c'.$item->container->name);

                    $int_trans += is_null($rate) ? 0 : $rate;
                }

            }

            // LCL
            if($data['type_transport'] == 'CONSOLIDADO')
            {
                dd($data);

            }

            $cif = $int_trans + $data['commodity'];

            return [
                'int_trans' => $int_trans,
                'cif'       => $cif
            ];


        }
    }

}
