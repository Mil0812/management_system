<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NetProfitResource\Pages;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NetProfitResource extends Resource
{
    protected static ?string $model = NetProfit::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Чистий прибуток';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationGroup = 'Доходи-витрати';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNetProfits::route('/'),
            'create' => Pages\CreateNetProfit::route('/create'),
            'edit' => Pages\EditNetProfit::route('/{record}/edit'),
        ];
    }
}
