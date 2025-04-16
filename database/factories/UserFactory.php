<?php

namespace Database\Factories;

use App\Models\Club;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        $imageName = 'avatars/default.jpg';

        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('password'),
            'image' => $imageName,
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


    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
