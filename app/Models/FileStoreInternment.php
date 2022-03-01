<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileStoreInternment extends Model
{
    use HasFactory;

    protected $table = 'file_store_internments';

    public $timestamps = false;

    protected $fillable = [
        'file_store_id', 'internment_id', 'intl_treaty'
    ];

    public function fileStore()
    {
        return $this->hasOne(FileStore::class,'id','file_store_id');
    }

}
