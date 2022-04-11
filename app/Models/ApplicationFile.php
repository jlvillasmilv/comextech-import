<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationFile extends Model
{
    protected $table = 'application_files';

    protected $fillable = [
        'application_id', 'file_store_id', 'application_document_file_id'
    ];


    public function fileStore()
    {
        return $this->hasOne(FileStore::class,'id','file_store_id');
    }

    public function applicationDocumentFile()
    {
        return $this->belongsTo(ApplicationDocumentFile::class,'application_document_file_id','id');
    }
    
}
