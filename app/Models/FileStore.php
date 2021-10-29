<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class FileStore extends Model
{
    use HasFactory;

    protected $table = 'file_stores';

    protected $fillable = [
        'disk', 'type', 'file_name', 'mime_type', 'status'
    ];


    public function addFile($file,$name=null)
    {
        $file_name = is_null($name) ?  time() . '_' . $file->getClientOriginalName() : $name;

        // $exists = Storage::disk('s3')
        // ->exists('file/'.$file_name);

        // if($exists){
        //     Storage::disk('s3')
        //     ->delete('file/'.$file_name);
        // }
       
        Storage::disk('s3')->put('file/'.$file_name, \File::get($file));
        
        $fileStorage = FileStore::updateOrCreate([
            'file_name'     => $file_name,
        ],
        [   'disk'          => Storage::disk('s3')->url('file/'.$file_name),
            'mime_type'     => $file->getMimeType(),
        ]
        );

        return $fileStorage;
    }

    public function FileStoreClient()
    {
        return $this->hasOne(Factoring\FileStoreClient::class);
    }

    public function FileDisbursement()
    {
        return $this->hasOne(Factoring\FileDisbursement::class, 'disbursement_id');
    }


}
