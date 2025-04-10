<?php

namespace Database\Factories;

use App\Models\Expenses;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Expenses>
 */
class ExpensesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => $this->faker->sentence(3),
            'amount' => $this->faker->randomFloat(2, 50, 9999.99),
            'month' => $this->faker->randomElement(['January', 'February', 'March', 'April', 'May',
                'June', 'July', 'August', 'September', 'October', 'November', 'December']),
            'year' => $this->faker->numberBetween(2020, 2030),
        ];
    }
}
