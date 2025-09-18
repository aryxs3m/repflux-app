<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkoutResource\Pages;
use App\Filament\Resources\WorkoutResource\WorkoutForm;
use App\Models\Workout;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class WorkoutResource extends Resource
{
    protected static ?string $model = Workout::class;

    protected static ?string $slug = 'workouts';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Bolt;

    public static function getNavigationLabel(): string
    {
        return __('navbar.workouts');
    }

    public static function getBreadcrumb(): string
    {
        return __('navbar.workouts');
    }

    public static function form(Schema $schema): Schema
    {
        return WorkoutForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('workout_at', 'desc')
            ->columns([
                TextColumn::make('workout_at')
                    ->label('Workout Date')
                    ->date(),

                TextColumn::make('notes'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWorkouts::route('/'),
            'view' => Pages\ViewWorkout::route('/view/{record}'),
            'edit' => Pages\EditWorkout::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['tenant']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['tenant.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->tenant) {
            $details['Tenant'] = $record->tenant->name;
        }

        return $details;
    }
}
