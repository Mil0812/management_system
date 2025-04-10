<?php

namespace Database\Factories;

use App\Models\Club;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ];
    }

    public function teacher()
    {
        return $this->state([])->afterCreating(function (User $user) {
            $user->assignRole('teacher');
        });
    }

    public function admin()
    {
        return $this->state([])->afterCreating(function (User $user) {
            $user->assignRole('admin');
        });
    }

    public function configure(): Factory|UserFactory
    {
        return $this->afterCreating(function (User $user) {
            $clubs = Club::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $user->clubs()->sync($clubs);
        });
    }


    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
