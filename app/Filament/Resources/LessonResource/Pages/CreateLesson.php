<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Filament\Resources\LessonResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateLesson extends CreateRecord
{
    protected static string $resource = LessonResource::class;

    protected function handleRecordCreation(array $data): Model
    {
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
