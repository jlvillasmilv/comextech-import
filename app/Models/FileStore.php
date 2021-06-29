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
        'path', 'type', 'original_name', 'mime_type', 'status'
    ];


    public function addFile($request)
    {

        $file    = $request->file('file');

        $file_name = time() . '_' . $file->getClientOriginalName();
        Storage::disk('s3')->put('file/'.$file_name, \File::get($file));
        
        $fileStorage = FileStore::create([
            'path' =>  Storage::disk('s3')->url('file/'.$file_name),
            'original_name' => $file_name,
            'mime_type'     => $file->getMimeType(),
        ]);

        return $fileStorage;
        
    }


}
