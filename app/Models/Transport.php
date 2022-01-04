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
        return $this->belongsTo(Port::class,'origin_port_id')->withDefault(['name' => '', 'unlocs' => '' ]);
    }

    public function originAddress()
    {
        return $this->belongsTo(SupplierAddress::class,'origin_address')->withDefault(['address' => '', 'place' => '' ]);
    }

    public function destAddress()
    {
        return $this->belongsTo(CompanyAddress::class,'dest_address')->withDefault(['address' => '', 'place' => '' ]);
    }

    public function destPort()
    {
        return $this->belongsTo(Port::class,'dest_port_id')->withDefault(['name' => '', 'unlocs' => '' ]);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class,'supplier_id')->withDefault(['name' => '' ]);
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
        $oth_exp  = 0;
        $t_time = 1;
        $rate_insurance_transp = 0;
        $type_mark_up = 'air';

        if(count($data) > 0)
        {
            //Rate FCL
            if($data['type_transport'] == 'CONTAINER')
            {
                $type_mark_up = 'fcl';
                $rate_insurance_transp = \DB::table('settings')->first(['min_rate_fcl'])->min_rate_fcl;

                foreach($data['cargo'] as $item) {
                    $field = 'c'.$item->container->name;
                    $rate = \DB::table('rate_fcl')
                    ->where([
                        ['status', true],
                        ['from', $data['from']],
                        ['to', $data['to']],
                    ])
                    ->select($field, 'oth_exp', 't_time')
                    ->orderBy('valid_to', 'desc')
                    ->first();

                    $int_trans += is_null($rate) ? 0 : $rate->$field;
                    $oth_exp   += is_null($rate) ? 0 : $rate->oth_exp;
                    $t_time    =  is_null($rate) ? 12 : $rate->t_time;
                }

            }

            // Rate LCL
            if($data['type_transport'] == 'CONSOLIDADO')
            {
                $type_mark_up = 'lcl';
                $rate_insurance_transp = \DB::table('settings')->first(['min_rate_lcl'])->min_rate_lcl;

                foreach($data['cargo'] as $item) {

                    $field = 'MIN_0_5';

                    $higher = $item['cbm'] > ($item['weight']/1000) ? $item['cbm'] : ($item['weight']/1000) ;
                    
                    if ($item['cbm'] > ($item['weight']/1000)) {
                        $field = $higher <= 5 ? 'w0_5_TON_M3' : ($higher >= 6 && $higher <= 9 ? 'w5_10_TON_M3' : 'w10_15_TON_M3') ; 
                    }
                    
                    if ($item['cbm'] < ($item['weight']/1000)) {
                        $field = $higher <= 5 ? 'MIN_0_5' : ($higher >= 6 && $higher <= 9 ? 'MIN_5_10' : 'MIN_10_5') ; 
                    }

                    $rate =  \DB::table('rate_lcl')
                    ->where([
                        ['status', true],
                        ['from', $data['from']],
                        ['to', $data['to']],
                    ])
                    ->orderBy('valid_to', 'desc')
                    ->select( $field , 'oth_exp', 't_time')
                    ->first();

                    $int_trans += is_null($rate) ? 0 : $rate->$field * $higher ;
                    $oth_exp   += is_null($rate) ? 0 : $rate->oth_exp;
                    $t_time    =  is_null($rate) ? 12 : $rate->t_time;
                     
                }

            }

             // Rate AIR
             if($data['type_transport'] == 'AEREO')
             {
                $type_mark_up = 'air';
                $rate_insurance_transp =  \DB::table('settings')->first(['min_rate_aereo'])->min_rate_aereo;
                $int_trans = 0;
                $oth_exp   = 0;
                $t_time    = 0;
 
            }

            //profit margin 
            $mark_up =  \DB::table('user_mark_ups')
            ->where('user_id', auth()->user()->id)
            ->first($type_mark_up)->$type_mark_up;

            $mark_up = round(1 / ((100 - (is_null($mark_up) ? 40 : $mark_up) )/100), 2);

            $int_trans = $mark_up * $int_trans;

            $cif = $int_trans + $data['commodity'];

            $insurance = $cif * 0.035 > $rate_insurance_transp ? $cif * 0.035 : $rate_insurance_transp;

            if($oth_exp>0){ 
                $exchange = New Currency;
                $oth_exp = $exchange->convertCurrency($oth_exp, 'USD', 'CLP');
            }

        }

        return [
            'int_trans' => $int_trans,
            'oth_exp'   => $oth_exp,
            'cif'       => $cif,
            't_time'    => $t_time,
            'insurance' => $insurance,
        ];  
    }

    public static function rateLocalTransport($data)
    {
       $rtl = 0;
       $type = $data['mode_selected'] == 'AEREO' ? 'A' : 'P';

       if(count($data['dataLoad']) > 0){

        $province =  $data['fav_dest_address'] ? \DB::table('company_addresses')->where('id', $data['dest_address'])->first(['province'])->province 
            : $data['dest_province'];

        foreach($data['dataLoad'] as $item){

            $tl = \DB::table('rate_local_transports')
            ->where([
               ['to',$province],
               ['type', $type],
               ['status', true]
            ])
            ->whereRaw("? BETWEEN weight AND weight_limit", $item['weight'])
            ->first(['amount'])->amount;
    
            $rtl += $tl;

        }

       }

        return $rtl;
    }

    public static function rateLocalCourierExpenses($data=null)
    {
        // if (!is_null($data)){

        //     $rlce = \DB::table('rate_lce')
        //     ->where([
        //         ['status', true],
        //         ['trans_company_id', $data['trans_company_id']],
        //         ])
        //     ->whereRaw("? BETWEEN initial AND limit", $data['amount'])
        //     ->first(['rate']);

        //     dd($rlce);

        //     return 0;

        // }
        return 0;
    }
    

}
