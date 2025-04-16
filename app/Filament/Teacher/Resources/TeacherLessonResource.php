<?php

namespace App\Filament\Teacher\Resources;

use App\Models\Club;
use App\Models\Lesson;
use App\Models\Student;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class TeacherLessonResource extends Resource
{
    protected static ?string $model = Lesson::class;

    protected static ?string $navigationIcon = 'heroicon-s-academic-cap';
    protected static ?string $navigationLabel = 'Уроки';
    protected static ?string $modelLabel = 'Урок';
    protected static ?string $pluralModelLabel = 'Уроки';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('students')
                    ->multiple()
                    ->label('Учні')
                    ->options(Student::all()->pluck('name', 'id'))
                    ->live()
                    ->afterStateUpdated(function ($state, callable $get, callable $set) {
                        $cost = $get('cost') ?? 0;
                        $studentCount = count($state);
                        $set('student_count', $studentCount);
                        $set('total_profit', $studentCount * $cost);
                    })
                    ->searchable(),

                TextInput::make('student_count')
                    ->label('Кількість дітей')
                    ->disabled()
                    ->default(0),

                Select::make('club_id')
                    ->label('Назва гуртка')
                    ->options(function () {
                        $teacherId = Auth::id();
                        return Club::whereHas('teachers', function ($query) use ($teacherId) {
                            $query->where('teacher_id', $teacherId);
                        })->pluck('name', 'id');
                    })
                    ->searchable()
                    ->required(),

                DatePicker::make('lesson_date')
                    ->label('Дата заняття')
                    ->default(now('Europe/Kiev')->toDateString())
                    ->required(),

                TimePicker::make('lesson_time')
                    ->label('Час заняття')
                    ->seconds(false)
                    ->default(now('Europe/Kiev')->format("H:i"))
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
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('club.name')->label('Назва гуртка')->sortable(),
                TextColumn::make('lesson_date')->label('Дата заняття'),
                TextColumn::make('lesson_time')->label('Час заняття'),
                TextColumn::make('student_count')->label('Кількість дітей')->sortable(),
                TextColumn::make('cost')
                    ->label('Вартість заняття за людину')
                    ->money('UAH'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('club_id')
                    ->label('Гурток')
                    ->options(function () {
                        $teacherId = Auth::id();
                        return Club::whereHas('teachers', function ($query) use ($teacherId) {
                            $query->where('teacher_id', $teacherId);
                        })->pluck('name', 'id');
                    }),
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
            'index' => TeacherLessonResource\Pages\ListTeacherLessons::route('/'),
            'create' => TeacherLessonResource\Pages\CreateTeacherLesson::route('/create'),
            'edit' => TeacherLessonResource\Pages\EditTeacherLesson::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        // Обмежуємо уроки до тих, які належать поточному вчителю
        return parent::getEloquentQuery()->where('teacher_id', Auth::id());
    }
}
