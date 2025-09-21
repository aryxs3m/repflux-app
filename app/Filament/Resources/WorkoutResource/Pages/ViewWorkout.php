<?php

namespace App\Filament\Resources\WorkoutResource\Pages;

use App\Filament\Resources\WorkoutResource;
use App\Filament\Resources\WorkoutResource\Widgets\WorkoutStats;
use App\Services\Settings\Tenant;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Contracts\Support\Htmlable;

class ViewWorkout extends ViewRecord
{
    protected static string $resource = WorkoutResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('pages.workouts.view_title');
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            WorkoutStats::class,
            WorkoutResource\Widgets\WorkoutCategoryChart::class,
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema->schema([
            Flex::make([
                Section::make([
                    RepeatableEntry::make('recordSets')
                        ->hiddenLabel()
                        ->columns(3)
                        ->schema([
                            TextEntry::make('user.name')
                                ->columnSpan(1),
                            TextEntry::make('recordType.name')
                                ->columnSpan(1),
                            TextEntry::make('recordType.recordCategory.name')
                                ->columnSpan(1),
                            RepeatableEntry::make('records')
                                ->hiddenLabel()
                                ->schema([
                                    TextEntry::make('repeat_count')
                                        ->hiddenLabel()
                                        ->suffix('x'),
                                    TextEntry::make('weight_with_base')
                                        ->hiddenLabel()
                                        ->suffix(' '.Tenant::getWeightUnitLabel()),
                                ])
                                ->columns(2)
                                ->columnSpanFull(),
                        ]),
                ]),
                Section::make([
                    TextEntry::make('workout_at'),
                    TextEntry::make('created_at'),
                    TextEntry::make('updated_at'),
                ])->grow(false),
            ])
                ->from('md'),
        ])
            ->columns(1);
    }
}
