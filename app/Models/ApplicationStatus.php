<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationStatus extends Model
{
    use HasFactory;

    protected $table = 'application_statuses';
    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}