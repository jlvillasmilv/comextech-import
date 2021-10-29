<?php

namespace App\Models\Factoring;

use Illuminate\Database\Eloquent\Model;

class ClientLegalInfo extends Model
{
    protected $table = 'factoring_client_legal_infos';

    protected $fillable = [
        'client_id',
        'user_id',
        'writing_date',
        'notary',
        'repertoire_number',
    ];

    public function client()
    {
        return $this->belongsTo(\App\Models\User::class, 'client_id')->withDefault(['rut' => ' ','first_name' => '','last_name' => '' ]);
    }
}
