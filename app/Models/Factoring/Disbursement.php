<?php

namespace App\Models\Factoring;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disbursement extends Model
{
    use SoftDeletes;
    public $table = 'factoring_disbursements';

    protected $fillable = [
        'application_id',
        'status',
        'total_amount',
        'created_users_id',
        'modified_users_id',
        'tax_debt',
        'assign_invoices_sii',
        'assignment_annex',
        'status_view',
        'bank_accounts_id',
    ];

    const STATUS_ICON = [
        'PENDIENTE'      => 'far fa-clock fa-2x',
        'DESEMBOLSADO'   => 'fa fa-check-double fa-2x',
        'RECHAZADO'      => 'fa fa-times  fa-2x',
        'EN MORA'      => 'fa fa-exclamation-circle fa-2x',
        'PAGADO'      => 'fa fa-clipboard-check fa-2x',
    ];

    
    const STATUS_COLOR = [
        'PENDIENTE'      => '#6c757d',
        'DESEMBOLSADO'   => '#1DC80D',
        'RECHAZADO' => 'red',
        'EN MORA' => '#ECDD2C',
        'PAGADO'      => '#00BD2D',
    ];

    protected $dates = [
        'writing_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    function scopeApproved($query)
    {
        if(auth()->user()->hasRole('Client')) {
            return $query->join('factoring_applications', 'factoring_applications.id', '=', 'factoring_disbursements.application_id')
            ->where('factoring_applications.client_id', '=', auth()->user()->client->id)
            ->where('factoring_applications.status', '=', 'Aprobada')
            ->whereNotIn('factoring_disbursements.status', ['RECHAZADO', 'PENDIENTE']);
        }
        return 0;
    }
    public function created_user()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_users_id');
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class,'bank_accounts_id');
    }

    public function application()
    {
        return $this->belongsTo(Application::class,'factoring_application_id');
    }

    public function file_disbursement()
    {
        return $this->hasMany(FileDisbursement::class,'factoring_disbursement_id');
    }
}
