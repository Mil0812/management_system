<?php

namespace App\Filament\Teacher\Resources\TeacherLessonResource\Pages;

use App\Filament\Teacher\Resources\TeacherLessonResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CreateTeacherLesson extends CreateRecord
{
    protected static string $resource = TeacherLessonResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $data['teacher_id'] = Auth::id();

        $students = $data['students'] ?? [];
        unset($data['students']);

        $studentCount = count($students);
        $data['student_count'] = $studentCount;
        $data['total_profit'] = $studentCount * ($data['cost'] ?? 0);


        $lesson = static::getModel()::create($data);

        $lesson->students()->sync($students);

        return $lesson;
    }
}
