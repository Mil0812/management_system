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

    // Обробка даних перед оновленням
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['student_count'] = count($data['student_id'] ?? []);
        $data['total_profit'] = $data['student_count'] * ($data['cost'] ?? 0);
        return $data;
    }
}
