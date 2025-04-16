<?php

namespace Database\Factories;

use App\Models\Club;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $imageName = 'clubs/default.jpg';

        return [
            'name' => $this->faker->unique()->randomElement([
                'Математика', 'Малювання', 'Музика', 'Кулінарія', 'Творчість',
                'Шахи', 'Арт-креатив', 'Танці', 'IT', 'Іноземні мови'
            ]),
            'description' => $this->faker->text(),
            'image' => $imageName,
        ];
    }
    public function configure(): ClubFactory|Factory
    {
        return $this->afterCreating(function (Club $club) {
            $teachers = User::role('teacher')->inRandomOrder()->take(rand(1, 3))->pluck('id');
            foreach ($teachers as $teacherId) {
                if (!$club->teachers()->where('teacher_id', $teacherId)->exists()) {
                    $club->teachers()->attach($teacherId);
                }
            }
        });
    }
}
