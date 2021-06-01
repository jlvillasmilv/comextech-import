<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'companies';
    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(Invoice::class,'application_id');
    }
}
