<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApplicationStatus extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'application_statuses';
    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
