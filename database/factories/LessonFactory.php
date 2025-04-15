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
        $studentCount = $this->faker->numberBetween(1, 10);
        $cost = $this->faker->randomFloat(2, 50, 200);
        return [
            'teacher_id' => User::whereHas('roles', function ($query) {
                $query->where('name', 'teacher');
            })->inRandomOrder()->first()->id ?? UserFactory::new()->teacher()->create()->id,
            'student_count' => $studentCount,
            'club_id' => function (array $attributes) {
                $teacher = User::find($attributes['teacher_id']);
                return $teacher->clubs()->inRandomOrder()->first()->id ?? Club::factory()->create()->id;
            },'lesson_date' => $this->faker->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d'),
            'lesson_time' => $this->faker->time('H:i:s'),
            'cost' => $cost,
            'total_profit' => $cost * $studentCount,
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
