<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Filament\Resources\LessonResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateLesson extends CreateRecord
{
    protected static string $resource = LessonResource::class;

    // Обробка даних перед створенням
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['student_count'] = count($data['student_id'] ?? []);
        $data['total_profit'] = $data['student_count'] * ($data['cost'] ?? 0);
        return $data;
    }
}
