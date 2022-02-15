<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreightShipment extends Model
{
    protected $table = 'freight_shipments';
    protected $guarded = [];

    public function freightQuote()
    {
        return $this->belongsTo(FreightQuote::class,'freight_quotes_id');
    }

    public function categoryLoad()
    {
        return $this->belongsTo(CategoryLoad::class,'category_load_id')->withDefault(['name' => '' ]);
    }

    public function container()
    {
        return $this->belongsTo(CategoryContainer::class,'type_container')->withDefault(['name' => '' ]);
    }
}
