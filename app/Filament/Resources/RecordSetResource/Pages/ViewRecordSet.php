<?php

namespace App\Filament\Resources\RecordSetResource\Pages;

use App\Filament\Resources\RecordSetResource;
use App\Filament\Resources\RecordSetResource\Actions\ReplicateRecordSetAction;
use App\Filament\Resources\RecordSetResource\Widgets\RecordSetChart;
use App\Filament\Resources\RecordTypeResource\ExerciseType;
use App\Filament\Resources\WorkoutResource\Pages\ViewWorkout;
use App\Models\Record;
use App\Models\RecordSet;
use App\Services\Settings\Tenant;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class ViewRecordSet extends ViewRecord
{
    protected static string $resource = RecordSetResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('pages.record_sets.view_title');
    }

    public function getSubheading(): string|Htmlable|null
    {
        return sprintf(
            '%s, %s (%s)',
            $this->record->recordType->name,
            $this->record->set_done_at->diffForHumans(),
            $this->record->user->name
        );
    }

    protected function getHeaderWidgets(): array
    {
        return [
            RecordSetResource\Widgets\RecordSetStats::class,
        ];
    }

    protected function getFooterWidgets(): array
    {
        if ($this->record->recordType->exercise_type !== ExerciseType::WEIGHT) {
            return [];
        }

        return [
            RecordSetChart::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label(__('pages.record_sets.back'))
                ->icon(Heroicon::OutlinedArrowLeft)
                ->url(ListRecordSets::getUrl())
                ->color('gray'),
            Action::make('workout')
                ->label(__('pages.record_sets.workout'))
                ->icon(Heroicon::OutlinedBolt)
                ->url(ViewWorkout::getUrl(['record' => $this->getRecord()->workout]))
                ->color('gray'),
            CreateAction::make()
                ->label(__('pages.record_sets.add_set')),
            EditAction::make(),
            ReplicateRecordSetAction::make(),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Weights and repeats')
                ->visible(fn (RecordSet $record) => $record->recordType->exercise_type !== ExerciseType::CARDIO)
                ->schema([
                    RepeatableEntry::make('records')
                        ->hiddenLabel()
                        ->schema([
                            TextEntry::make('repeat_index')
                                ->suffix('. '.__('columns.reps_short'))
                                ->hiddenLabel(),
                            TextEntry::make('repeat_count')
                                ->suffix('x')
                                ->hiddenLabel(),
                            TextEntry::make('weight_with_base')
                                ->visible(fn (Record $record) => $record->recordSet->recordType->exercise_type === ExerciseType::WEIGHT)
                                ->hiddenLabel()
                                ->suffix(' '.Tenant::getWeightUnitLabel()),
                        ])->columns([
                            'default' => 3,
                        ]),
                ])->columnSpanFull(),
            Section::make('Exercise')->schema([
                TextEntry::make('recordType.name'),
                TextEntry::make('recordType.recordCategory.name')
                    ->label('Category'),
            ])->columns(2),
            Section::make('Record')->schema([
                TextEntry::make('set_done_at')
                    ->date(),
                TextEntry::make('user.name'),
            ])->columns(2),
        ]);
    }
}
