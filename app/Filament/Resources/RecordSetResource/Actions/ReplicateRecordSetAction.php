<?php

namespace App\Filament\Resources\RecordSetResource\Actions;

use App\Models\Record;
use App\Models\RecordSet;
use App\Services\Settings\Tenant;
use App\Services\Workout\WorkoutService;
use Filament\Actions\ReplicateAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Model;

class ReplicateRecordSetAction extends ReplicateAction
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('pages.record_sets.clone_set'));
        $this->color('success');
        $this->icon(Heroicon::OutlinedClipboardDocument);

        $this->modalHeading(__('pages.record_sets.clone_set'));
        $this->modalSubmitActionLabel(__('pages.record_sets.clone_set'));

        $this->schema([
            Select::make('user_id')
                ->label(__('pages.record_sets.new_user'))
                ->options(Tenant::getTenant()->users->pluck('name', 'id'))
                ->formatStateUsing(fn () => Tenant::otherUser()?->id)
                ->searchable()
                ->preload()
                ->required(),
            DatePicker::make('set_done_at'),
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
        ]);

        $this->after(function (Model $replica, array $data) {
            /** @var RecordSet|Model $replica */
            $id = $replica->id;

            $index = 0;
            Record::query()->insert(array_map(function ($record) use ($id, &$index) {
                $index++;

                return array_merge($record, [
                    'repeat_index' => $index,
                    'record_set_id' => $id,
                ]);
            }, $data['records']));

            app(WorkoutService::class)->sync($replica);
        });
    }
}
