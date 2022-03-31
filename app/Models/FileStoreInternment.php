<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    public static function checkFileExists($data)
    {

        $file = FileStoreInternment::where([
            ['internment_id', $data['internment_id']],
            ['intl_treaty', $data['intl_treaty']],
        ])
        ->first();
        

        if(!is_null($file))
        {
             // $exists = Storage::disk('s3')
            // ->exists('file/'.$file_name);

            // if($exists){
            //     Storage::disk('s3')
            //     ->delete('file/'.$file_name);
            // }

        }

    }

}
