<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\Club;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-s-users';
    protected static ?string $navigationLabel = 'Вчителі';
    protected static ?string $modelLabel = 'Вчитель';
    protected static ?string $pluralModelLabel = 'Вчителі';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Прізвище, ім`я')
                    ->required(),

                TextInput::make('email')
                    ->label('Електронна пошта')
                    ->email()
                    ->unique()
                    ->required(),

                TextInput::make('password')
                    ->label('Пароль')
                    ->password(),

                FileUpload::make('image')
                    ->label('Аватар')
                    ->image()
                    ->disk('public')
                    ->maxSize(2048)
                    ->directory('avatars')
                    ->nullable(),

                Select::make('clubs')
                    ->label('Гуртки')
                    ->required()
                    ->multiple()
                    ->options(Club::all()->pluck('name', 'id'))
                    ->searchable()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Аватар')
                    ->circular()
                    ->getStateUsing(function ($record) {
                        $url = $record->image ? Storage::disk('public')->url($record->image) : null;
                        return $url;
                    }),
                TextColumn::make('name')->label('Прізвище, ім`я')->searchable(),
                TextColumn::make('email')->label('Електронна пошта'),
                TextColumn::make('clubs.name')
                    ->listWithLineBreaks()
                    ->label('Гуртки')
                    ->searchable(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
