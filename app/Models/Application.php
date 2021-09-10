<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\HasAdvancedFilter;

class Application extends Model
{
    use HasFactory;
    use HasAdvancedFilter;
    use SoftDeletes;

    protected $table = 'applications';
    protected $fillable = ['user_id',
                           'supplier_id',
                           'application_statuses_id',
                           'currency_id',
                           'description',
                           'condition',
                           'fee1',
                           'fee1_date',
                           'fee2',
                           'fee2_date',
                           'fee3',
                           'fee3_date',
                           'amount',
                           'charge',
                           'commission',
                           'interest',
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

    public function detailsCatregory()
    {
        return $this->hasMany(ApplicationDetail::class,'application_id');
    }

    public function summary()
    {
        return $this->hasMany(ApplicationSumamry::class,'application_id')->OrderBy('id');
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
        return $this->hasMany(PaymentProvider::class,'application_id')->orderBy('id');
    }

    public function transport()
    {
        return $this->hasOne(Transport::class,'application_id');
    }

    public function internmentProcess()
    {
        return $this->hasOne(InternmentProcess::class,'application_id');
    }

    public function cargo()
    {
        return $this->hasMany(Load::class,'application_id');
    }

    public function localWarehouse()
    {
        return $this->hasOne(LocalWarehouse::class,'application_id');
    }

}
