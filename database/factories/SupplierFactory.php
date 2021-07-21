<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SupplierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Supplier::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => 2,
            'name'    => $this->faker->name,
            'address' => $this->faker->address,
            'bank'    => $this->faker->domainWord,
            'isin'    => rand(100000, 900000),
            'iban'    => $this->faker->bankAccountNumber,
            'phone'   => $this->faker->phoneNumber,
            'email'   => $this->faker->unique()->safeEmail,
            'origin_transport' => $this->faker->address,
        ];
    }
}
