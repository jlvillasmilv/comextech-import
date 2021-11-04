<?php

namespace App\Models\Factoring;

use Illuminate\Database\Eloquent\Model;

class FileDisbursement extends Model
{

    protected $table = 'factoring_file_disbursements';

    protected $fillable = [
        'disbursement_id', 'file_store_id', 'type'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    public function disbursement()
    {
        return $this->belongsTo(Disbursement::class, 'disbursement_id');
    }

    public function fileStore()
    {
        return $this->belongsTo(App\Models\FileStore::class);
    }
}
