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
            ['code' => 'ICS01','name' => 'Pagos', 'user_id' => 1, 'dependence' => '', 'ind_service' => true, 'sort' => 1, 'status' => true, 'icon' => "vs:p-square" ], 
            ['code' => 'ICS02','name' => 'Bodegaje y Fulfillment ', 'user_id' => 1, 'dependence' => '4,5,7,8', 'ind_service' => true, 'sort' => 4, 'status' => true, 'icon' => "vs:b-square", ], 
            ['code' => 'ICS03','name' => 'Transporte', 'user_id' => 1,'dependence' => '', 'ind_service' => true, 'sort' => 2,'status' => true, 'icon' => "vs:t-square" ], 
            ['code' => 'ICS04','name' => 'Aduana', 'user_id' => 1,'dependence' => '', 'ind_service' => true, 'sort' => 3,'status' => true,'icon' => "vs:a-square" ], 
            ['code' => 'ICS05','name' => 'Entrega', 'user_id' => 1, 'dependence' => '2,3,4,5,6,7', 'ind_service' => true, 'sort' => 5,'status' => false,'icon' => "vs:e-square" ],
            ['code' => 'ICS06','name' => 'Transporte Local', 'user_id' => 1,'dependence' => '', 'ind_service' => false, 'sort' => 6,'status' => true,'icon' => "vs:t-square" ],
            ['code' => 'ICS07','name' => 'Tipo de cambio', 'user_id' => 1,'dependence' => '', 'ind_service' => false, 'sort' => 7,'status' => false,'icon' => "vs:p-square" ], 
            ['code' => 'ICS08','name' => 'Financiamiento', 'user_id' => 1, 'dependence' => '2,3,4,5,7,8', 'ind_service' => true, 'sort' => 9,'status' => true, 'icon' => "vs:f-square" ], 
        ]);

        \DB::table('services')->insert([
            ['category_service_id' => 1, 'code' => 'ICS01-01', 'name' => 'Pago Adelanto', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 1, 'code' => 'ICS01-02', 'name' => 'Pago SALDO', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 1, 'code' => 'ICS01-03', 'name' => 'Otros', 'created_at' => now(), 'summary' => false ], 
            ['category_service_id' => 2, 'code' => 'ICS02-01', 'name' => 'Inspeccion Carga', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 2, 'code' => 'ICS02-02', 'name' => 'Bodegaje/Consolidación', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 2, 'code' => 'ICS02-03', 'name' => 'Otros', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 3, 'code' => 'ICS03-01', 'name' => 'Tranporte Internacional', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 3, 'code' => 'ICS03-02', 'name' => 'Seguro Transporte', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 4, 'code' => 'ICS04-01', 'name' => 'Servicio AGA (agente de Aduana)', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 4, 'code' => 'ICS04-02', 'name' => 'IVA Internacion', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 4, 'code' => 'ICS04-03', 'name' => 'Ad-Valorem', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 5, 'code' => 'ICS05-01', 'name' => 'Bodega', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 5, 'code' => 'ICS05-02', 'name' => 'Distribución Local', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 6, 'code' => 'ICS06-01', 'name' => 'Almacenaje', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 6, 'code' => 'ICS06-02', 'name' => 'Transporte Local', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 7, 'code' => 'ICS07-01', 'name' => 'Compra y venta', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 7, 'code' => 'ICS07-02', 'name' => 'Transferencia', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 8, 'code' => 'ICS08-01', 'name' => 'Financiamiento', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 8, 'code' => 'ICS08-02', 'name' => 'Financiamiento', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 1, 'code' => 'CS01-01', 'name' => 'A.- Pago proveedor', 'created_at' => now(), 'summary' => true ],
            ['category_service_id' => 1, 'code' => 'CS01-02', 'name' => 'A.1.- Adelanto', 'created_at' => now(), 'summary' => true ],
            ['category_service_id' => 1, 'code' => 'CS01-03', 'name' => 'A.2.- Saldo', 'created_at' => now(), 'summary' => true ],
            ['category_service_id' => 3, 'code' => 'CS03-01', 'name' => 'B.- Transporte Internacional', 'created_at' => now(), 'summary' => true ],
            ['category_service_id' => 3, 'code' => 'CS03-02', 'name' => 'C.- Seguro Transporte', 'created_at' => now(), 'summary' => true ],
            ['category_service_id' => 4, 'code' => 'CS04-01', 'name' => 'D.- Servicio AGA', 'created_at' => now(), 'summary' => true ],
            ['category_service_id' => 4, 'code' => 'CS04-02', 'name' => 'E.- IVA Internacion', 'created_at' => now(), 'summary' => true ],
            ['category_service_id' => 4, 'code' => 'CS04-03', 'name' => 'F.- Aranceles', 'created_at' => now(), 'summary' => true ],
            ['category_service_id' => 6, 'code' => 'CS06-01', 'name' => 'G.- Transporte Local', 'created_at' => now(), 'summary' => true ],
            ['category_service_id' => 6, 'code' => 'CS06-02', 'name' => 'H.- Otro gatos', 'created_at' => now(), 'summary' => true ],
        ]);


    }
}
