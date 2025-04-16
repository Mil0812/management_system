<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExpensesResource\Pages;
use App\Models\Expenses;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ExpensesResource extends Resource
{
    protected static ?string $model = Expenses::class;

    protected static ?string $navigationIcon = 'heroicon-s-currency-dollar';
    protected static ?string $navigationLabel = 'Витрати';
    protected static ?string $modelLabel = 'Витрати';
    protected static ?string $pluralModelLabel = 'Витрати';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationGroup = 'Доходи-витрати';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('description')
                    ->label('Джерело витрат')
                    ->maxLength(255)
                    ->required(),

                TextInput::make('amount')
                    ->label('Сума')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(999999.99)
                    ->step(0.01)
                    ->dehydrateStateUsing(fn ($state) => number_format($state, 2, '.', '')),

                Select::make('month')
                    ->label('Місяць')
                    ->options([
                        'January' => 'Січень',
                        'February' => 'Лютий',
                        'March' => 'Березень',
                        'April' => 'Квітень',
                        'May' => 'Травень',
                        'June' => 'Червень',
                        'July' => 'Липень',
                        'August' => 'Серпень',
                        'September' => 'Вересень',
                        'October' => 'Жовтень',
                        'November' => 'Листопад',
                        'December' => 'Грудень',
                    ])
                    ->default(date('F'))
                    ->searchable()
                    ->required(),

                TextInput::make('year')
                    ->label('Рік')
                    ->numeric()
                    ->minValue(2000)
                    ->maxValue(date('Y') + 10)
                    ->default(date('Y'))
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('description')
                    ->label('Джерело витрат')
                    ->searchable(),
                TextColumn::make('amount')
                    ->label('Сума')
                    ->money('UAH')
                    ->sortable(),
                TextColumn::make('month')
                    ->label('Місяць')
                    ->formatStateUsing(fn ($state) => [
                        'January' => 'Січень',
                        'February' => 'Лютий',
                        'March' => 'Березень',
                        'April' => 'Квітень',
                        'May' => 'Травень',
                        'June' => 'Червень',
                        'July' => 'Липень',
                        'August' => 'Серпень',
                        'September' => 'Вересень',
                        'October' => 'Жовтень',
                        'November' => 'Листопад',
                        'December' => 'Грудень',
                    ][$state])
                    ->sortable(),
                TextColumn::make('year')
                    ->label('Рік')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Дата створення')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('month')
                    ->options([
                        'January' => 'Січень',
                        'February' => 'Лютий',
                        'March' => 'Березень',
                        'April' => 'Квітень',
                        'May' => 'Травень',
                        'June' => 'Червень',
                        'July' => 'Липень',
                        'August' => 'Серпень',
                        'September' => 'Вересень',
                        'October' => 'Жовтень',
                        'November' => 'Листопад',
                        'December' => 'Грудень',
                    ]),
                Tables\Filters\Filter::make('year')
                    ->form([
                        TextInput::make('year')->numeric(),
                    ])
                    ->query(fn (Builder $query, array $data) => $query->when($data['year'], fn (Builder $query) => $query->where('year', $data['year']))),
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
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpenses::route('/create'),
            'edit' => Pages\EditExpenses::route('/{record}/edit'),
        ];
    }
}
