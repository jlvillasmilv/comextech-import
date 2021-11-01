<?php

namespace App\Models\Factoring;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'factoring_applications';

    const STATUS_COLOR = [
        'En Proceso'  => '#6c757d',
        'Aprobada'    => '#5cb85c',
        'Rechazada'   => '#d9534f',
    ];

    const STATUS_ICON = [
        'En Proceso'  => 'far fa-clock fa-lg',
        'Aprobada'    => 'far fa-check-circle fa-lg',
        'Rechazada'   => 'far fa-times-circle fa-lg',
    ];


    protected $fillable = [
        'user_id',
        'status',
        'contract_status',
        'disbursement_status',
        'observation',
        'description',
        'modified_users_id',
     ];

    protected $dates = [
    'created_at',
    'updated_at',
    ];


    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class,'user_id','user_id')
        ->withDefault(['tax_id' => ' ','name' => '' ]);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class,'factoring_application_id');
    }

    public function refund()
    {
        return $this->hasMany(Refund::class);
    }

    public function disbursement()
    {
        return $this->hasOne(Disbursement::class,'factoring_application_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function calculateInvoice($data)
    {
       
       /********* Verificar Si Pagador Existe */
        $payer = Payer::where('rut', $data['rut'])->first();
        /********* Tasa por default */
     
        if(is_null($payer)){
            $fee = \App\Models\Setting::first();
        } else{

            $payerClient  = auth()->user()->ClientPayer->where('payer_id', $payer->id)->first();
            $fee  = is_null($payerClient) || is_null($payerClient->feeshistory->last())?  \App\Models\Setting::first() : $payerClient->feeshistory->last(); 
        }    

       $rate         = $fee->rate;
       $mora_rate    = $fee->mora_rate;
       $discount     = $fee->discount;
       $commission   = $fee->commission;
         
       $expire = isset($data['payment_date']) ? $data['payment_date'] : $data['expire_date'];

       /********* Fechas de calculos */
       $date1 = date_create($expire);
       $date2 = date_create(date("Y-m-d"));
       $payment_real = date_diff($date1, $date2);

      /*******Diferencia******** */
       $dif = (($rate / 100) * ($discount / 100) * $data['total_amount'] * ($payment_real->days / 30)); 

       /************DESCUENTO***** */
        $discon =   round($dif, 2) +  $commission ;

        /*********DESEMBOLSO********** */
        $disbursement =  $data['total_amount'] * ($discount / 100) - $discon ;

        /********Excedentes****** */
        $surplus = $data['total_amount'] * (1-($discount / 100));

        $result = [
                    'rate'          => $rate,
                    'mora_rate'     => $mora_rate,
                    'rut'           => $data['rut'],
                    'total_amount'  => $data['total_amount'],
                    'discount'      => $discount,
                    'commission'    => $commission,
                    'dif'           => round($dif, 2),
                    'discon'        => $discon,
                    'disbursement'  => $disbursement,
                    'surplus'       => round($surplus, 2),
                    'number'        => $data['number'],
                    'payment_real'  => $payment_real,
                    'issuing_date'  => $data['issuing_date'],
                    'expire_date'   => $expire ,
                    'payer'         => $data['payer']
                ];

       return $result;

    }

}
