<?php

namespace App\Models\Factoring;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    protected $fillable = [
        'factoring_application_id', 'description'
    ];

    protected $table = 'factoring_refunds';

   /**
     * Get the application associated with the refund.
     */
    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
