<?php

namespace App\Filament\Resources\WorkoutResource\Pages;

use App\Filament\Resources\RecordSetResource\Pages\CreateRecordSet;
use App\Filament\Resources\RecordSetResource\Pages\ViewRecordSet;
use App\Filament\Resources\RecordTypeResource\CardioMeasurementTransformer;
use App\Filament\Resources\RecordTypeResource\ExerciseType;
use App\Filament\Resources\WorkoutResource;
use App\Filament\Resources\WorkoutResource\Widgets\WorkoutStats;
use App\Models\RecordSet;
use App\Services\Settings\Tenant;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
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
            Action::make('create_record_set')
                ->label(__('pages.record_sets.add_set'))
                ->color('success')
                ->icon(Heroicon::OutlinedPlusCircle)
                ->url(CreateRecordSet::getUrl()),
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
                            Grid::make(4)
                                ->visible(fn ($record) => $record->recordType->exercise_type === ExerciseType::CARDIO)
                                ->schema(fn ($record) => CardioMeasurementTransformer::getEntries($record))
                                ->columnSpanFull(),
                            Section::make('Set')
                                ->collapsed()
                                ->headerActions([
                                    Action::make('view_set')
                                        ->color('gray')
                                        ->url(fn (RecordSet $recordSet) => ViewRecordSet::getUrl(['record' => $recordSet])),
                                ])
                                ->schema([
                                    RepeatableEntry::make('records')
                                        ->visible(fn ($record) => $record->recordType->exercise_type !== ExerciseType::CARDIO)
                                        ->hiddenLabel()
                                        ->schema([
                                            TextEntry::make('repeat_index')
                                                ->hiddenLabel()
                                                ->suffix('. '.__('columns.reps_short')),
                                            TextEntry::make('repeat_count')
                                                ->hiddenLabel()
                                                ->suffix('x'),
                                            TextEntry::make('weight_with_base')
                                                ->visible(fn ($record) => $record->recordSet->recordType->exercise_type === ExerciseType::WEIGHT)
                                                ->hiddenLabel()
                                                ->suffix(' '.Tenant::getWeightUnitLabel()),
                                        ])
                                        ->columns(3)
                                        ->columnSpanFull(),
                                ])
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
