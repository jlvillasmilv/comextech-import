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
        return $this->belongsTo(CategoryLoad::class,'category_load_id')->withDefault(['name' => '' ]);
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

            if($item['id'] > 0){
                // update register
                Load::where([
                    ['id', $item['id']],
                    ['application_id', $application_id]
                    ])
                ->update([
                    'type_container' => $item['type_container'],
                    'cbm'            => $item['cbm'],
                    'stackable'      => $item['stackable'],
                    'length_unit'    => $item['length_unit'],
                    'length'         => $item['length'],
                    'width'          => $item['width'],
                    'height'         => $item['height'],
                    'type_container' => $item['type_container'],
                    'category_load_id'      => $item['category_load_id'],
                    'weight'         => $item['weight'],
                    'weight_units'   => $item['weight_units'],
                ]);


            } else{
                //created
                Load::updateOrInsert(
                    [
                     'application_id' => $application_id,
                     'type_container' => $item['type_container'],
                     'weight'         => $item['weight'],
                    ],
                    [
                        'cbm'            => $item['cbm'],
                        'stackable'      => $item['stackable'],
                        'length_unit'    => $item['length_unit'],
                        'length'         => $item['length'],
                        'width'          => $item['width'],
                        'height'         => $item['height'],
                        'category_load_id'      => $item['category_load_id'],
                        'weight'         => $item['weight'],
                        'weight_units'   => $item['weight_units'],
                    ]
                );

            }
        
          }

        return true;
    }
}
