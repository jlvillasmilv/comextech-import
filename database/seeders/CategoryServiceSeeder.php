<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoryServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

         
        \DB::table('category_services')->insert([
            ['name' => 'Pago Proveedor', 'user_id' => 1, 'dependence' => '', 'ind_service' => true, 'sort' => 1, 'created_at' => now() ], 
            ['name' => 'Servicios en Origen', 'user_id' => 1, 'dependence' => '4,5,7,8', 'ind_service' => false, 'sort' => 2,'created_at' => now(), ], 
            ['name' => 'Transporte Internacional', 'user_id' => 1,'dependence' => '', 'ind_service' => true, 'sort' => 3,'created_at' => now() ], 
            ['name' => 'Proceso de Internación', 'user_id' => 1,'dependence' => '', 'ind_service' => true, 'sort' => 4,'created_at' => now() ], 
            ['name' => 'Bodegaje Local', 'user_id' => 1, 'dependence' => '2,3,4,5,6,7', 'ind_service' => false, 'sort' => 5,'created_at' => now() ],
            ['name' => 'Transporte Local', 'user_id' => 1,'dependence' => '', 'ind_service' => true, 'sort' => 6,'created_at' => now() ],
            ['name' => 'Financiamiento', 'user_id' => 1, 'dependence' => '2,3,4,5,7,8', 'ind_service' => false, 'sort' => 7, 'created_at' => now() ], 
            ['name' => 'Gestion del Tipo de Cambio', 'user_id' => 1,'dependence' => '', 'ind_service' => true, 'sort' => 8,'created_at' => now() ], 
        ]);

        \DB::table('services')->insert([
            ['category_service_id' => 1, 'name' => 'Pago Adelanto ', 'created_at' => now() ],
            ['category_service_id' => 1, 'name' => 'Pago Adelanto 2 ', 'created_at' => now() ],
            ['category_service_id' => 1, 'name' => 'Otros', 'created_at' => now() ], 
            ['category_service_id' => 2, 'name' => 'Inspeccion Carga', 'created_at' => now() ],
            ['category_service_id' => 2, 'name' => 'Bodegaje//Consolidación', 'created_at' => now() ],
            ['category_service_id' => 2, 'name' => 'Otros', 'created_at' => now() ],
            ['category_service_id' => 3, 'name' => 'Pago de Tranporte Internacional', 'created_at' => now() ],
            ['category_service_id' => 3, 'name' => 'Pago Seguro Transporte', 'created_at' => now() ],
            ['category_service_id' => 3, 'name' => 'Otros', 'created_at' => now() ],
            ['category_service_id' => 4, 'name' => 'AGA (agente de Aduana)', 'created_at' => now() ],
            ['category_service_id' => 4, 'name' => 'IVA Internacion', 'created_at' => now() ],
            ['category_service_id' => 4, 'name' => 'Ad-Valorem', 'created_at' => now() ],
            ['category_service_id' => 4, 'name' => 'Otros', 'created_at' => now() ], 
            ['category_service_id' => 5, 'name' => 'Bodega', 'created_at' => now() ],
            ['category_service_id' => 5, 'name' => 'Distribución Local', 'created_at' => now() ],
            ['category_service_id' => 5, 'name' => 'Otros', 'created_at' => now() ],
            ['category_service_id' => 6, 'name' => 'Almacenaje', 'created_at' => now() ],
            ['category_service_id' => 6, 'name' => 'Transporte Local', 'created_at' => now() ],
            ['category_service_id' => 6, 'name' => 'Otros', 'created_at' => now() ],
            ['category_service_id' => 7, 'name' => 'Financiamiento', 'created_at' => now() ],
            ['category_service_id' => 8, 'name' => 'Compra y venta', 'created_at' => now() ],
            ['category_service_id' => 8, 'name' => 'Transferencia', 'created_at' => now() ],
            ['category_service_id' => 8, 'name' => 'Otros', 'created_at' => now() ],
        ]);

    }
}
