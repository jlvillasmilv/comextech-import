<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\HasAdvancedFilter;
use Illuminate\Support\Str;

class Application extends Model
{
    use HasFactory;
    use HasAdvancedFilter;
    use SoftDeletes;

    protected $table = 'applications';
    protected $fillable = ['user_id',
                           'supplier_id',
                           'application_statuses_id',
                           'type_transport',
                           'currency_id',
                           'ecommerce_id',
                           'ecommerce_url',
                           'condition',
                           'fee1',
                           'fee1_date',
                           'fee2',
                           'fee2_date',
                           'fee3',
                           'fee3_date',
                           'amount',
                           'services_code',
                           'modified_user_id',
                            ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $orderable = [
        'id',
        'created_at',
    ];

    public $filterable = [
        'id',
        'created_at',
    ];

    public function validStatus($id)
    {
        $data = $this->where('id', $id)->first();

        if(is_null($data)){

            return 0;
        }

        $status = ApplicationStatus::findOrFail($data->application_statuses_id);

        if(!$status->modify || !$status->client_modify){

            return 'No puede modificar solicitud '. $status->name;
        }

        return 0;
    }


    public static function boot()
    {
        parent::boot();

        /**
        * Write code on Method
        *
        * @return response()
        */
        static::creating(function($model){
            $number = Application::max('id')+1;
           
            $model->code = 'AI-'.str_pad($number,6,0, STR_PAD_LEFT); // Str::upper(Str::random(6));
        });
    }


    // /**
    //  * Write code on Method
    //  *
    //  * @return response()
    // */
    // public static function generateUniqueCode($id)
    // {
    //     do {
    //         $code = 'AI-'.str_pad($id,6,0, STR_PAD_LEFT); // Str::upper(Str::random(6));
    //     } while (Application::where("code", "=", $code)->first());
  
    //     return $code;
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class,'currency_id')->withDefault(['code' => '', 'symbol' => '' ]);
    }

    public function details()
    {
        return $this->hasMany(ApplicationDetail::class,'application_id')->OrderBy('id');
    }

    public function summary()
    {
        return $this->hasMany(ApplicationSummary::class,'application_id')->where('status', true)->OrderBy('id');
    }

    public function requirements()
    {
        return $this->hasMany(RequirementsApplication::class,'application_id');
    }

    public function status()
    {
        return $this->belongsTo(ApplicationStatus::class, 'application_statuses_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id')->withDefault(['name' => '' ]);
    }

    public function suppliers()
    {
        return $this->belongsToMany('App\Supplier', 'application_supplier', 
        'application_id', 'supplier_id');
    }

    public function paymentProvider()
    {
        return $this->hasMany(PaymentProvider::class,'application_id')->orderBy('id')->select('*',\DB::raw("'ICS01' as code_serv"));
    }

    public function transport()
    {
        return $this->hasOne(Transport::class,'application_id')->select('*',\DB::raw("'ICS03' as code_serv"));
    }

    public function internmentProcess()
    {
        return $this->hasOne(InternmentProcess::class,'application_id')->select('*',\DB::raw("'ICS04' as code_serv"));
    }

    public function loads()
    {
        return $this->hasMany(Load::class,'application_id');
    }

    public function localWarehouse()
    {
        return $this->hasOne(LocalWarehouse::class,'application_id')->select('*',\DB::raw("'ICS05' as code_serv"));
    }

}
