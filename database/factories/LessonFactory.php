<?php

namespace Database\Factories;

use App\Models\Club;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lesson>
 */
class LessonFactory extends Factory
{
    protected $model = Lesson::class;

    public function definition(): array
    {
        return [
            'teacher_id' => User::whereHas('roles', function ($query) {
                    $query->where('name', 'teacher');
                })->inRandomOrder()->first()->id ?? User::factory()->teacher(),
            'student_count' => $this->faker->numberBetween(1, 10),
            'club_id' => Club::inRandomOrder()->first()->id ?? Club::factory(),
            'lesson_date' => $this->faker->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d'),
            'lesson_time' => $this->faker->time('H:i:s'),
            'cost' => $this->faker->randomFloat(2, 50, 200),
            'total_profit' => $this->faker->randomFloat(2, 50, 200),
        ];
    }

    public function configure(): Factory|LessonFactory
    {
        return $this->afterCreating(function (Lesson $lesson) {
            $students = Student::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $lesson->students()->sync($students);
        });
    }
}
