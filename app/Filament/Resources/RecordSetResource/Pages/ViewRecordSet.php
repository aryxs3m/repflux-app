<?php

namespace App\Filament\Resources\RecordSetResource\Pages;

use App\Filament\Resources\RecordSetResource;
use App\Filament\Resources\RecordSetResource\Widgets\RecordSetChart;
use App\Filament\Resources\RecordTypeResource\ExerciseType;
use App\Models\Record;
use App\Models\RecordSet;
use App\Services\Settings\Tenant;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\ReplicateAction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;

class ViewRecordSet extends ViewRecord
{
    protected static string $resource = RecordSetResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('pages.record_sets.view_title');
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
            CreateAction::make()
                ->label(__('pages.record_sets.add_set')),
            EditAction::make(),
            ReplicateAction::make()
                ->color('success')
                ->icon(Heroicon::OutlinedClipboardDocument)
                ->modalHeading(__('pages.record_sets.clone_set'))
                ->modalSubmitActionLabel(__('pages.record_sets.clone_set'))
                ->schema([
                    Select::make('user_id')
                        ->label(__('pages.record_sets.new_user'))
                        ->options(Tenant::getTenant()->users->pluck('name', 'id'))
                        ->searchable()
                        ->preload()
                        ->required(),
                    Repeater::make('records')
                        ->hiddenLabel()
                        ->cloneable()
                        ->afterStateHydrated(function (Set $set) {
                            $records = $this->getRecord()->records->toArray();

                            $defaults = array_map(function ($record) {
                                return [
                                    'repeat_count' => $record['repeat_count'],
                                    'weight' => $record['weight'],
                                ];
                            }, $records);

                            $set('records', $defaults);
                        })
                        ->orderColumn('repeat_index')
                        ->reorderableWithButtons()
                        ->reorderableWithDragAndDrop(false)
                        ->minItems(1)
                        ->addActionLabel('Add repetition')
                        ->schema([
                            TextInput::make('repeat_count')
                                ->suffix('reps')
                                ->numeric()
                                ->minValue(0)
                                ->columnSpan(1),
                            TextInput::make('weight')
                                ->suffix(Tenant::getWeightUnitLabel())
                                ->numeric()
                                ->minValue(0)
                                ->columnSpan(1),
                        ])
                        ->columns([
                            'default' => 2,
                        ]),
                ])
                ->after(function (Model $replica, array $data) {
                    $id = $replica->id;

                    $index = 0;
                    Record::query()->insert(array_map(function ($record) use ($id, $index) {
                        $index++;

                        return array_merge($record, [
                            'repeat_index' => $index,
                            'record_set_id' => $id,
                        ]);
                    }, $data['records']));
                })
                ->label(__('pages.record_sets.clone_set')),
        ];
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Weights and repeats')
                ->visible(fn (RecordSet $record) => $record->recordType->exercise_type === 'weight')
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
