<?php

namespace App\Filament\Teacher\Resources\TeacherLessonResource\Pages;

use App\Filament\Teacher\Resources\TeacherLessonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditTeacherLesson extends EditRecord
{
    protected static string $resource = TeacherLessonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $students = $data['students'] ?? [];
        unset($data['students']);

        $studentCount = count($students);
        $data['student_count'] = $studentCount;
        $data['total_profit'] = $studentCount * ($data['cost'] ?? 0);

        $record->update($data);

        $record->students()->sync($students);

        return $record;
    }
}
