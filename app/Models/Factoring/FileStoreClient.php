<?php

namespace App\Models\Factoring;

use Illuminate\Database\Eloquent\Model;

class FileStoreClient extends Model
{
    protected $table = 'factoring_file_stores_clients';

    protected $fillable = [
        'client_id', 'file_store_id', 'type'
    ];


    public function client()
    {
        return $this->belongsTo(App\Models\User::class,'client_id');
    }

    public function fileStore()
    {
        return $this->belongsTo(App\Models\FileStore::class);
    }
}
