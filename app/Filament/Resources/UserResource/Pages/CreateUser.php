<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    // Прив'язання вчителя до гуртків, що йому належать
    protected function handleRecordCreation(array $data): Model
    {

        $clubs = $data['clubs'] ?? [];
        unset($data['clubs']);

        $user = static::getModel()::create($data);
        $user->clubs()->sync($clubs);
        $user->assignRole('teacher');

        return $user;
    }
}
