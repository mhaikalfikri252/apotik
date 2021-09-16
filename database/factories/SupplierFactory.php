<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'name' => $this->faker->companyPrefix . '.' . $this->faker->lastName,
            'phone' => '08' . mt_rand(1000000000, 9999999999),
            'email' => $this->faker->unique()->safeEmail,
            'account_number' => mt_rand(10000000000000, 99999999999999),
            'address' => $this->faker->streetAddress . '-' . $this->faker->city . '-' . $this->faker->postcode
            . '-' . $this->faker->stateAbbr,
        ];
    }
}
