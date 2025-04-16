<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LubResource\Pages;
use App\Models\Club;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClubResource extends Resource
{
    protected static ?string $model = Club::class;

    protected static ?string $navigationIcon = 'heroicon-s-academic-cap';
    protected static ?string $navigationLabel = 'Гуртки';
    protected static ?string $modelLabel = 'Гурток';
    protected static ?string $pluralModelLabel = 'Гуртки';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Назва гуртка')
                    ->maxLength(30)
                    ->required(),

                TextInput::make('description')
                ->label('Опис'),

                FileUpload::make('image')
                    ->image()
                    ->label('Зображення')
                    ->directory('clubs')
                    ->maxSize(2048)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Зображення')
                    ->circular()
                    ->getStateUsing(function ($record) {
                        return filter_var($record->image, FILTER_VALIDATE_URL)
                            ? $record->image : ($record->image ? 'storage/' . $record->image : null);
                    }),
                TextColumn::make('name')
                    ->label('Назва гуртка'),
                TextColumn::make('description')
                    ->label('Опис'),
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
            'index' => Pages\ListLubs::route('/'),
            'create' => Pages\CreateLub::route('/create'),
            'edit' => Pages\EditLub::route('/{record}/edit'),
        ];
    }
}
