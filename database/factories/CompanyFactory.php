<?php

namespace Database\Factories;

use App\Models\{Company, Country, User};

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => function () {
                return  \App\Models\User::factory()->create()->id;
            },
            'country_id' => Country::all()->random()->id,
            'tax_id' => $this->faker->unique()->creditCardNumber,
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            
        ];
    }
}
