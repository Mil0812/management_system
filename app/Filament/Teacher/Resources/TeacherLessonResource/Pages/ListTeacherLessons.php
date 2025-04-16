<?php

namespace App\Filament\Teacher\Resources\TeacherLessonResource\Pages;

use App\Filament\Teacher\Resources\TeacherLessonResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTeacherLessons extends ListRecords
{
    protected static string $resource = TeacherLessonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
