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
            ['code' => 'ICS01', 'name' => 'Pagos', 'user_id' => 1, 'dependence' => '', 'ind_service' => true, 'sort' => 1, 'status' => true, 'icon' => "noto-v1:letter-p" ], 
            ['code' => 'ICS02', 'name' => 'Servicios en Origen', 'user_id' => 1, 'dependence' => '4,5,7,8', 'ind_service' => false, 'sort' => 2, 'status' => false, 'icon' => "noto-v1:letter-s", ], 
            ['code' => 'ICS03','name' => 'Transporte', 'user_id' => 1,'dependence' => '', 'ind_service' => true, 'sort' => 3,'status' => true, 'icon' => "noto-v1:letter-t" ], 
            ['code' => 'ICS04','name' => 'Aduana', 'user_id' => 1,'dependence' => '', 'ind_service' => true, 'sort' => 4,'status' => true,'icon' => "noto-v1:letter-a" ], 
            ['code' => 'ICS05','name' => 'Tipos de cambio', 'user_id' => 1, 'dependence' => '2,3,4,5,6,7', 'ind_service' => true, 'sort' => 5,'status' => true,'icon' => "noto-v1:letter-t" ],
            ['code' => 'ICS06','name' => 'Transporte Local', 'user_id' => 1,'dependence' => '', 'ind_service' => false, 'sort' => 6,'status' => true,'icon' => "noto-v1:letter-t" ],
            ['code' => 'ICS07','name' => 'Pagos', 'user_id' => 1,'dependence' => '', 'ind_service' => false, 'sort' => 7,'status' => false,'icon' => "noto-v1:letter-p" ], 
            ['code' => 'ICS08','name' => 'Financiamiento', 'user_id' => 1, 'dependence' => '2,3,4,5,7,8', 'ind_service' => false, 'sort' => 8,'status' => false, 'icon' => "noto-v1:letter-f" ], 
        ]);

        \DB::table('services')->insert([
            ['category_service_id' => 1, 'name' => 'Pago Adelanto', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 1, 'name' => 'Pago SALDO', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 1, 'name' => 'Otros', 'created_at' => now(), 'summary' => false ], 
            ['category_service_id' => 2, 'name' => 'Inspeccion Carga', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 2, 'name' => 'Bodegaje/Consolidación', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 2, 'name' => 'Otros', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 3, 'name' => 'Tranporte Internacional', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 3, 'name' => 'Seguro Transporte', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 4, 'name' => 'Servicio AGA (agente de Aduana)', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 4, 'name' => 'IVA Internacion', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 4, 'name' => 'Ad-Valorem', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 5, 'name' => 'Bodega', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 5, 'name' => 'Distribución Local', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 6, 'name' => 'Almacenaje', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 6, 'name' => 'Transporte Local', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 7, 'name' => 'Compra y venta', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 7, 'name' => 'Transferencia', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 8, 'name' => 'Financiamiento', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 8, 'name' => 'Financiamiento', 'created_at' => now(), 'summary' => false ],
            ['category_service_id' => 1, 'name' => 'A.- Pago proveedor', 'created_at' => now(), 'summary' => true ],
            ['category_service_id' => 1, 'name' => 'A.1.- Adelanto', 'created_at' => now(), 'summary' => true ],
            ['category_service_id' => 1, 'name' => 'A.2.- Saldo', 'created_at' => now(), 'summary' => true ],
            ['category_service_id' => 3, 'name' => 'B.- Transporte Internacional', 'created_at' => now(), 'summary' => true ],
            ['category_service_id' => 3, 'name' => 'C.- Seguro Transporte', 'created_at' => now(), 'summary' => true ],
            ['category_service_id' => 4, 'name' => 'D.- Servicio AGA', 'created_at' => now(), 'summary' => true ],
            ['category_service_id' => 4, 'name' => 'E.- IVA Internacion', 'created_at' => now(), 'summary' => true ],
            ['category_service_id' => 4, 'name' => 'F.- Aranceles', 'created_at' => now(), 'summary' => true ],
            ['category_service_id' => 6, 'name' => 'G.- Transporte Local', 'created_at' => now(), 'summary' => true ],
        ]);


    }
}
