<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WorkoutResource\Pages;
use App\Filament\Resources\WorkoutResource\Schemas\WorkoutForm;
use App\Filament\Resources\WorkoutResource\Schemas\WorkoutTable;
use App\Models\Workout;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class WorkoutResource extends Resource
{
    protected static ?string $model = Workout::class;

    protected static ?string $slug = 'workouts';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBolt;

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
        return WorkoutTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWorkouts::route('/'),
            'view' => Pages\ViewWorkout::route('/view/{record}'),
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
