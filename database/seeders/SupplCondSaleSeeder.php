<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ApplicationCondSale;

class SupplCondSaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $sup = ApplicationCondSale::create([
            'user_id'   => 1,
            'name'      => 'EXW',
            'description' => 'Ex Works (named place) → ‘en fábrica (lugar convenido)’.
            El vendedor pone mercancía a disposición del comprador en sus propias instalaciones: fábrica, almacén, etc. Todos los gastos a partir de ese momento son por cuenta del comprador.
            ',
            'sort' => 1
        ]);

        $sup->services()->sync([1 => ['selected' => true],
        3=> ['selected' => true],
        4=> ['selected' => true],
        5=> ['selected' => true],
        7=> ['selected' => true],
        8=> ['selected' => true]]);

        $sup = ApplicationCondSale::create([
            'user_id'   => 1,
            'name'      => 'FCA',
            'description' => '“Free carrier”
            Free Carrier (named place) → ‘Libre transportista (lugar convenido)’.
            El vendedor se compromete a entregar la mercancía en un punto acordado dentro del país de origen, que pueden ser las bodegas de un Embarcador, un Puerto o Aeropuerto... (este lugar convenido para entregar la mercancía suele estar relacionado con los espacios del transportista). Se hace cargo de los costos hasta que la mercancía está situada en ese punto convenido.            
            ',
            'sort' => 2
        ]);

        $sup->services()->sync([1 => ['selected' => false],
        3=> ['selected' => true],
        4=> ['selected' => true],
        5=> ['selected' => true],
        7=> ['selected' => false],
        8=> ['selected' => false]
    ]);


        $sup = ApplicationCondSale::create([
            'user_id'   => 1,
            'name'      => 'FOB',
            'description' => '“Free On Board” (named loading port) → ‘Libre a bordo (puerto de carga convenido)’
            El vendedor entrega la mercancía sobre el buque. El comprador se hace cargo de designar y reservar el transporte principal (buque)
            ',
            'sort' => 3

        ]);

        
        $sup->services()->sync([1 => ['selected' => true],
            3=> ['selected' => true],
            4=> ['selected' => false],
            5=> ['selected' => true],
            7=> ['selected' => true],
            8=> ['selected' => true]
        ]);


        $sup = ApplicationCondSale::create([
            'user_id'   => 1,
            'name'      => 'CIF',
            'description' => '“ Cost, insurance and freight”
            Cost, Insurance and Freight (named destination port) → ‘coste, seguro y flete (puerto de destino convenido)’.
            ',
            'sort' => 4
        ]);

       
        $sup->services()->sync([1 => ['selected' => true],
            3=> ['selected' => false],
            4=> ['selected' => true],
            5=> ['selected' => true],
            7=> ['selected' => true],
            8=> ['selected' => true]
        ]);



        $sup = ApplicationCondSale::create([
            'user_id'   => 1,
            'name'      => 'DDP/DAP',
            'description' => '“Delivery Duty Paid”, significa que el vendedor debe poner las mercancías a disposición del comprador en el lugar acordado (la fábrica del comprador, un almacén, etc.), además de cubrir todos los gastos asociados, incluyendo la descarga de las mercancías y los procedimientos y costes aduaneros que se puedan aplicar.
            
            “Delivery at place”, requiere que la mercancía sea entregada por el vendedor en un lugar designado por el comprador. Normalmente esa entrega se realiza en las instalaciones del comprador. Por lo tanto, el comprador es el responsable de descargar los medios de transporte. Además, el vendedor debe realizar los trámites de exportación, mientras que el comprador debe realizar los trámites de importación.',
            'sort' => 5
        ]);

        $sup->services()->sync([1 => ['selected' => false],
            3=> ['selected' => false],
            4=> ['selected' => true],
            5=> ['selected' => true],
            7=> ['selected' => false],
            8=> ['selected' => false]
        ]);


        // $sup = ApplicationCondSale::create([
        //     'user_id'   => 1,
        //     'name'      => 'CFR',
        //     'description' => '“ Cost and Freight”, es un término utilizado en la compraventa internacional de mercancías para indicar que el vendedor debe responsabilizarse de hacer llegar la mercancía al punto de destino acordado con el comprador a bordo del medio de transporte que él mismo decida, así como del pago del coste del flete marítimo internacional. Cuando se dice punto de destino convenido nos estamos refiriendo al puerto de destino, pues el incoterm CFR es exclusivo del transporte marítimo. Es decir, una vez desembarcada la mercancía, cesan las obligaciones del vendedor. '
        // ]);

        // $sup->services()->sync([3,4,5]);

    }
}
