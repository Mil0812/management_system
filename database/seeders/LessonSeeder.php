<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Club;
use App\Models\Lesson;
use Illuminate\Support\Str;

class LessonSeeder extends Seeder
{
    public function run(): void
    {
        // Here we connect teachers with clubs
//        User::where('role', 'teacher')->each(function ($teacher)
//        {
//            $teacher->clubs()->attach(
//                Club::inRandomOrder()->limit(rand(1, 3))->pluck('id')
//            );
//        });

        Lesson::factory()->count(2)->create();
    }
}
