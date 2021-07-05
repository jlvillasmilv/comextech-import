<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SupplCondSale;

class SupplCondSaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $sup = SupplCondSale::create([
            'user_id'   => 1,
            'name'      => 'FOB',
            'description' => '“Free On Board” (named loading port) → ‘Libre a bordo (puerto de carga convenido)’
            El vendedor entrega la mercancía sobre el buque. El comprador se hace cargo de designar y reservar el transporte principal (buque)
            '
            
        ]);

        $sup->services()->sync([1,3]);

        $sup = SupplCondSale::create([
            'user_id'   => 1,
            'name'      => 'DDP/DAP',
            'description' => '“Delivery Duty Paid”, significa que el vendedor debe poner las mercancías a disposición del comprador en el lugar acordado (la fábrica del comprador, un almacén, etc.), además de cubrir todos los gastos asociados, incluyendo la descarga de las mercancías y los procedimientos y costes aduaneros que se puedan aplicar.
            
            “Delivery at place”, requiere que la mercancía sea entregada por el vendedor en un lugar designado por el comprador. Normalmente esa entrega se realiza en las instalaciones del comprador. Por lo tanto, el comprador es el responsable de descargar los medios de transporte. Además, el vendedor debe realizar los trámites de exportación, mientras que el comprador debe realizar los trámites de importación.'
        ]);

        $sup->services()->sync([4,5]);

        $sup = SupplCondSale::create([
            'user_id'   => 1,
            'name'      => 'EXW',
            'description' => 'Ex Works (named place) → ‘en fábrica (lugar convenido)’.
            El vendedor pone mercancía a disposición del comprador en sus propias instalaciones: fábrica, almacén, etc. Todos los gastos a partir de ese momento son por cuenta del comprador.
            '
        ]);

        $sup->services()->sync([4,5]);

        $sup = SupplCondSale::create([
            'user_id'   => 1,
            'name'      => 'CIF',
            'description' => '“ Cost, insurance and freight”
            Cost, Insurance and Freight (named destination port) → ‘coste, seguro y flete (puerto de destino convenido)’.
            '
        ]);

        $sup->services()->sync([4,5]);

    }
}
