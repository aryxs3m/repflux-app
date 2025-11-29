<?php

namespace App\Filament\Resources\WorkoutResource\Pages;

use App\Filament\Entries\StopwatchEntry;
use App\Filament\Resources\RecordSetResource\Actions\ReplicateRecordSetAction;
use App\Filament\Resources\RecordSetResource\Pages\CreateRecordSet;
use App\Filament\Resources\RecordSetResource\Pages\ViewRecordSet;
use App\Filament\Resources\RecordTypeResource\CardioMeasurementTransformer;
use App\Filament\Resources\RecordTypeResource\ExerciseType;
use App\Filament\Resources\WorkoutResource;
use App\Filament\Resources\WorkoutResource\Widgets\WorkoutStats;
use App\Models\RecordSet;
use App\Models\Workout;
use App\Services\Settings\Tenant;
use App\Services\Workout\WorkoutService;
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

/**
 * @property Workout $record
 */
class ViewWorkout extends ViewRecord
{
    protected static string $resource = WorkoutResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('pages.workouts.view_title');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return sprintf(
            '%s %s',
            $this->record->dominantCategory->name ?? '',
            $this->record->workout_at->diffForHumans(),
        );
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('create_record_set')
                ->label(__('pages.record_sets.add_set'))
                ->color('success')
                ->icon(Heroicon::OutlinedPlusCircle)
                ->url(CreateRecordSet::getUrl()),
            EditAction::make()
                ->color('gray'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            WorkoutStats::class,
            WorkoutResource\Widgets\WorkoutCategoryChart::class,
            WorkoutResource\Widgets\WorkoutWeightProgressionChart::class,
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        /** @var WorkoutService $ws */
        $ws = app(WorkoutService::class);
        $missingRecords = $ws::getMissingRecords($this->record);

        return $schema->schema([
            Flex::make([
                Section::make([
                    RepeatableEntry::make('recordSets')
                        ->hiddenLabel()
                        ->columns(3)
                        ->schema([
                            TextEntry::make('user.name')
                                ->hiddenLabel()
                                ->columnSpan(1),
                            TextEntry::make('recordType.name')
                                ->hiddenLabel()
                                ->columnSpan(1),
                            TextEntry::make('recordType.recordCategory.name')
                                ->hiddenLabel()
                                ->columnSpan(1),
                            Grid::make(4)
                                ->visible(fn ($record) => $record->recordType->exercise_type === ExerciseType::CARDIO)
                                ->schema(fn ($record) => CardioMeasurementTransformer::getEntries($record))
                                ->columnSpanFull(),
                            StopwatchEntry::make('time')
                                ->visible(fn ($record) => $record->recordType->exercise_type === ExerciseType::TIME),
                            Action::make('view_set')
                                ->visible(fn ($record) => in_array($record->recordType->exercise_type, [ExerciseType::CARDIO, ExerciseType::TIME]))
                                ->color('gray')
                                ->url(fn (RecordSet $recordSet) => ViewRecordSet::getUrl(['record' => $recordSet])),
                            Section::make('Set')
                                ->collapsed()
                                ->heading(__('common.details'))
                                ->visible(fn ($record) => in_array($record->recordType->exercise_type, [ExerciseType::WEIGHT, ExerciseType::OTHER]))
                                ->headerActions([
                                    Action::make('view_set')
                                        ->icon(Heroicon::OutlinedEye)
                                        ->tooltip(__('common.open'))
                                        ->color('gray')
                                        ->hiddenLabel()
                                        ->url(fn (RecordSet $recordSet) => ViewRecordSet::getUrl(['record' => $recordSet])),
                                    ReplicateRecordSetAction::make()
                                        ->tooltip(__('pages.record_sets.clone_set'))
                                        ->hiddenLabel(),
                                ])
                                ->schema([
                                    RepeatableEntry::make('records')
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
                                        ->columns([
                                            'default' => 3,
                                        ])
                                        ->columnSpanFull(),
                                ])
                                ->columnSpanFull(),
                        ]),
                ]),
                Section::make([
                    TextEntry::make('warnings')
                        ->label(__('pages.workouts.missing_records'))
                        ->color('danger')
                        ->bulleted()
                        ->visible($missingRecords->isNotEmpty())
                        ->state(function () use ($missingRecords) {
                            return $missingRecords->pluck('name');
                        }),
                    TextEntry::make('workout_at'),
                    TextEntry::make('created_at'),
                    TextEntry::make('updated_at'),
                    TextEntry::make('notes')
                        ->default('-'),
                ])->grow(false),
            ])
                ->from('md'),
        ])
            ->columns(1);
    }
}
