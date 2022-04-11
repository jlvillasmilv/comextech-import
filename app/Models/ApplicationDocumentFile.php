<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationDocumentFile extends Model
{
    protected $table = 'application_document_files';

    protected $fillable = [
        'name', 'status'
    ];

    
    public function applicationFile()
    {
        return $this->hasMany(ApplicationFile::class,'application_document_file_id');
    }

}
