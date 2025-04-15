<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Filament\Resources\LessonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditLesson extends EditRecord
{
    protected static string $resource = LessonResource::class;

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
