<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LessonResource\Pages;
use App\Models\Club;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\User;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('teacher_id')
                    ->options(User::all()->pluck('name', 'id'))
                    ->required(),

                Select::make('student_id')
                    ->multiple()
                    ->label('Students')
                    ->options(Student::all()->pluck('name', 'id'))
                    ->live()
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        $cost = $get('cost') ?? 0;
                        $set('student_count', count($state));
                        $set('total_profit', count($state) * $cost);
                    })
                    ->searchable(),

                TextInput::make('student_count')
                    ->label('Кількість студентів')
                    ->disabled()
                    ->default(0),

                Select::make('club_id')
                    ->label('Club')
                    ->options(Club::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                DatePicker::make('lesson_date')->required(),
                TimePicker::make('lesson_time')
                    ->seconds(false)
                    ->required(),

                TextInput::make('cost')
                    ->label('Вартість заняття за людину')
                    ->numeric()
                    ->minValue(0)
                    ->live()
                    ->inputMode('integer')
                    ->step(1)
                    ->formatStateUsing(fn ($state) => number_format($state, 2, '.', ''))
                    ->dehydrateStateUsing(fn ($state) => number_format($state, 2, '.', ''))
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        $studentCount = $get('student_count') ?? 0;
                        $set('total_profit', $studentCount * number_format($state, 2, '.', ''));
                    })
                    ->required(),

                TextInput::make('total_profit')
                    ->label('Загальний прибуток')
                    ->disabled()
                    ->default(0)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('teacher.name')->label('Вчитель'),
                TextColumn::make('student_count')->label('Кількість дітей')->sortable(),
                TextColumn::make('club.name')->label('Назва гуртка')->sortable(),
                TextColumn::make('lesson_date'),
                TextColumn::make('lesson_time'),
                TextColumn::make('cost')
                    ->label('Вартість заняття за людину')
                    ->money('UAH'),
                TextColumn::make('total_profit')
                    ->label('Загальний прибуток')
                    ->sortable()
                    ->money('UAH'),
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
            'index' => Pages\ListLessons::route('/'),
            'create' => Pages\CreateLesson::route('/create'),
            'edit' => Pages\EditLesson::route('/{record}/edit'),
        ];
    }
}
