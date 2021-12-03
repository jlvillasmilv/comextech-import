<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Load extends Model
{
    use HasFactory;

    protected $table = 'loads';
    protected $guarded = [];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    
    public function application()
    {
        return $this->belongsTo(Application::class,'application_id');
    }

    public function categoryLoad()
    {
        return $this->belongsTo(CategoryLoad::class,'type_load')->withDefault(['name' => '' ]);
    }

    public function container()
    {
        return $this->belongsTo(CategoryContainer::class,'type_container')->withDefault(['name' => '' ]);
    }

    public static function cargo($data,$application_id=null)
    {
        if(isset($data[0]['id'])) {

            $idload = array();

            foreach ($data as $key => $item) {
                $idload[] = $item['id'];
            }

            Load::whereNotIn('id', $idload)->where('application_id', $application_id)->delete();
        }
       
        foreach ($data as $key => $item) {

           
            Load::updateOrCreate(
                [
                 'application_id' => $application_id,
                 'type_container' => $item['type_container'],
                 'cbm'            => $item['cbm'],
                ],

                [
                    'stackable'      => $item['stackable'],
                    'length_unit'    => $item['length_unit'],
                    'length'         => $item['length'],
                    'width'          => $item['width'],
                    'height'         => $item['height'],
                    'type_container' => $item['type_container'],
                    'type_load'      => $item['type_load'],
                    'weight'         => $item['weight'],
                    'weight_units'   => $item['weight_units'],
                ]
            );
          }

        return true;
    }
}
