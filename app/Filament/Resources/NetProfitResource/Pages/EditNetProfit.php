<?php

namespace App\Filament\Resources\NetProfitResource\Pages;

use App\Filament\Resources\NetProfitResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNetProfit extends EditRecord
{
    protected static string $resource = NetProfitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
