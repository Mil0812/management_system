<?php

namespace Database\Factories;

use App\Models\Club;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Club>
 */
class ClubFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->randomElement([
                'Математика', 'Малювання', 'Музика', 'Кулінарія', 'Творчість'
            ]),
            'description' => $this->faker->text(),
        ];
    }
    public function configure(): ClubFactory|Factory
    {
        return $this->afterCreating(function (Club $club) {
            $teachers = User::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $club->teachers()->sync($teachers);
        });
    }
}
