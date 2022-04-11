<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ApplicationDocumentFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('application_document_files')->insert([
            ["name" => "Comercial Invoice", "created_at" => now() ], 
            ["name" => "Proforma Invoice", "created_at" => now() ], 
            ["name" => "Seguro de Carga", "created_at" => now() ],
            ["name" => "Copia de BL", "created_at" => now() ], 
            ["name" => "Liquidación del Agente Aduana", "created_at" => now() ], 
            ["name" => "Paking List", "created_at" => now() ], 
            ["name" => "Certificado aduanero", "created_at" => now() ], 
            ["name" => "Otros", "created_at" => now() ], 
        ]); 
    }
}
