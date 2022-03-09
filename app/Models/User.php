<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Support\HasAdvancedFilter;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasTeams;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;
    use HasRoles;
    use HasAdvancedFilter;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone'
    ];

    public $orderable = [
        'id',
        'name',
        'email',
    ];

    public $filterable = [
        'id',
        'name',
        'email',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function routeNotificationForWhatsApp()
    {
        return $this->phone;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }


    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function application()
    {
        return $this->hasMany(Application::class);
    }

    public function discount()
    {
        return $this->hasOne(UserDiscount::class);
    }

    public function discounts()
    {
        return $this->hasMany(UserDiscount::class);
    }

    public function jumpSellerUser()
    {
        return $this->hasOne(JumpSellerUser::class);
    }

    public function credential()
    {
        return $this->hasOne(UserCredential::class);
    }

    public function discountImport($data, $company = 'FEDEX')
    {
        $trans_company_id = TransCompany::where('name', $company)->first();

        $shipper_country_code = $data['origin_ctry_code'];

        // if favorite address origin is true find in storage
        if($data['fav_origin_address']){

            $address = SupplierAddress::where('id', $data['origin_address'])->firstOrFail();
            $shipper_country_code = $address->country_code;

        }

        $import_zone = Country::where('code', $shipper_country_code)->first();

        $zone = is_null($import_zone->IP) ? 'F' : $import_zone->IP ;

        if(($data['dataLoad'][0]['weight'] > 68 && $data['dataLoad'][0]['weight_units'] == 'KG') 
        || ($data['dataLoad'][0]['weight'] > 150 && $data['dataLoad'][0]['weight_units'] == 'LB')){ 
            $zone = is_null($import_zone->IPF) ? 'F' : $import_zone->IPF ;
          }

        $zone = 'imp_'.strtolower($zone);

        return auth()->user()->discount
                ->where('trans_company_id', $trans_company_id->id )
                ->first()->$zone;
    }

    //factoring 
    public function InvoicesHistory()
    {
        return $this->hasManyThrough(Factoring\InvoiceHistory::class, Factoring\ClientPayer::class);
    }

    public function credentialStores()
    {
        return $this->hasOne(UserCredential::class,'user_id')
        ->withDefault(['provider_name' => ' ','provider_password' => '' ]);
    }

    public function ClientPayer()
    {
        return $this->hasMany(Factoring\ClientPayer::class);
    }

    public function FileStoreClient()
    {
        return $this->hasMany(Factoring\FileStoreClient::class,'user_id');
    }

    public function client_legal_info()
    {
        return $this->hasMany(Factoring\ClientLegalInfo::class,'client_id');
    }

     /**
     * Get the Bank Account associated with the client.
     */
    public function bankAccounts()
    {
        return $this->hasMany(BankAccount::class,'user_id');
    }

    /**
     * Get the favorite Port with the client.
    */
    public function ports()
    {
        return $this->belongsToMany(
            Port::class,
            'ports_users',
            'user_id',
            'port_id',
        );
    }

    /**
     * Get the favorite Port with the client.
    */
    public function suppliers()
    {
        return $this->hasMany(Supplier::class,'user_id');
    }

    public function markUp()
    {
        return $this->hasOne(UserMarkUp::class,'user_id');
    }

}
