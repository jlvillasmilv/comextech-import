<?php

namespace Database\Factories;

use App\Models\SupplierAddress;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{Supplier, Country, User};

class SupplierAddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SupplierAddress::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'supplier_id' => function () {
                return  \App\Models\Supplier::factory()->create()->id;
            },
            'address'           => $this->faker->address.', '.$this->faker->country,
            'address_latitude'  => $this->faker->latitude,
            'address_longitude' => $this->faker->longitude,
            'postal_code'       => $this->faker->postcode,
            'place'             => $this->faker->randomElement(['ALMACEN', 'FABRICA', 'PUERTO']),
        ];
    }
}
