<?php

namespace App\Filament\Resources\RecordSetResource\Schemas;

use App\Filament\AbstractFormSchema;
use App\Filament\Resources\RecordTypeResource\CardioMeasurement;
use App\Filament\Resources\RecordTypeResource\CardioMeasurementTransformer;
use App\Filament\Resources\RecordTypeResource\ExerciseType;
use App\Models\RecordCategory;
use App\Models\RecordSet;
use App\Models\RecordType;
use App\Services\RecordSetSessionService;
use App\Services\Settings\Tenant;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class RecordSetForm extends AbstractFormSchema
{
    protected static function getExerciseFilter()
    {
        $recordSetSession = app(RecordSetSessionService::class);

        return Grid::make()->schema([
            ToggleButtons::make('record_category_id')
                ->live()
                ->dehydrated(false)
                ->options(RecordCategory::query()->get()->pluck('name', 'id'))
                ->inline()
                ->afterStateUpdated(function (Set $set) {
                    $set('record_type_id', null);
                }),
            Select::make('record_type_id')
                ->live()
                ->placeholder(fn (Get $get): string => empty($get('record_category_id')) ? 'First select category' : 'Select an option')
                ->options(function (?RecordSet $record, Get $get, Set $set, Field $component) use ($recordSetSession) {
                    if (! empty($record) && empty($get('record_category_id'))) {
                        $set('record_category_id', $record->recordType->recordCategory->id);
                        $set('record_type_id', $record->recordType->id);
                        $component->callAfterStateUpdated();
                    }

                    if (empty($record) && empty($get('record_category_id')) && $recordSetSession->hasLastRecord()) {
                        $set('record_category_id', $recordSetSession->getLastRecordCategoryId());
                        $set('record_type_id', $recordSetSession->getLastRecordTypeId());
                        $component->callAfterStateUpdated();
                    }

                    return RecordType::query()
                        ->where('record_category_id', $get('record_category_id'))
                        ->orderBy('name')
                        ->get()
                        ->pluck('name', 'id');
                })
                ->afterStateHydrated(function ($state, Field $component) {
                    $component->callAfterStateUpdated();
                })
                ->afterStateUpdated(function ($state, Set $set, Field $component) {
                    $component->hint(null);
                    $component->hintIcon(null);

                    if (! empty($state)) {
                        $recordType = RecordType::query()->find($state);

                        $set('exercise_type', $recordType->exercise_type);

                        if (empty($recordType?->notes)) {
                            return;
                        }

                        $component->hint($recordType->notes);
                        $component->hintIcon(Heroicon::InformationCircle);
                    }
                })
                ->required(),
            Hidden::make('exercise_type')
                ->live()
                ->default(ExerciseType::WEIGHT),
        ]);
    }

    protected static function getSetWizardStep(): Wizard\Step
    {
        $recordSetSession = app(RecordSetSessionService::class);

        return Wizard\Step::make('Set')
            ->schema([
                Select::make('user_id')
                    ->options(Tenant::getTenant()->users->pluck('name', 'id'))
                    ->searchable()
                    ->default(auth()->id())
                    ->preload()
                    ->required(),
                DatePicker::make('set_done_at')
                    ->label('Set Done Date')
                    ->default($recordSetSession->getLastSetDone() ?? now())
                    ->required(),
                self::getExerciseFilter(),
            ]);
    }

    protected static function getWeightRepsWizardStep(): Wizard\Step
    {
        return Wizard\Step::make('Repetitions')
            ->visible(fn (Get $get) => $get('exercise_type') === ExerciseType::WEIGHT)
            ->schema([
                Repeater::make('records')
                    ->relationship('records')
                    ->hiddenLabel()
                    ->cloneable()
                    ->orderColumn('repeat_index')
                    ->reorderableWithButtons()
                    ->reorderableWithDragAndDrop(false)
                    ->addActionLabel('Add repetition')
                    ->schema([
                        TextInput::make('repeat_count')
                            ->suffix('reps')
                            ->numeric()
                            ->minValue(1)
                            ->required()
                            ->columnSpan(1),
                        TextInput::make('weight')
                            ->suffix(Tenant::getWeightUnitLabel())
                            ->numeric()
                            ->minValue(0)
                            ->required()
                            ->columnSpan(1),
                    ])
                    ->columns([
                        'default' => 2,
                    ]),
            ]);
    }

    protected static function getOtherRepsWizardStep(): Wizard\Step
    {
        return Wizard\Step::make('Repetitions')
            ->visible(fn (Get $get) => $get('exercise_type') === ExerciseType::OTHER)
            ->schema([
                Repeater::make('records')
                    ->relationship('records')
                    ->hiddenLabel()
                    ->cloneable()
                    ->orderColumn('repeat_index')
                    ->reorderableWithButtons()
                    ->reorderableWithDragAndDrop(false)
                    ->addActionLabel('Add repetition')
                    ->schema([
                        TextInput::make('repeat_count')
                            ->suffix('reps')
                            ->numeric()
                            ->minValue(1)
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columns([
                        'default' => 2,
                    ]),
            ]);
    }

    protected static function getResultsWizardStep(): Wizard\Step
    {
        return Wizard\Step::make('Results')
            ->visible(fn (Get $get) => $get('exercise_type') === ExerciseType::CARDIO)
            ->schema(function (Get $get) {
                $recordTypeId = $get('record_type_id');

                if ($recordTypeId == null) {
                    return [];
                }

                $recordType = RecordType::query()->find($recordTypeId);

                if (! $recordType->cardio_measurements) {
                    return [];
                }

                $items = [];
                foreach ($recordType->cardio_measurements as $item) {
                    $items[] = CardioMeasurementTransformer::getInput(CardioMeasurement::from($item));
                }

                return $items;
            });
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    self::getSetWizardStep(),
                    self::getWeightRepsWizardStep(),
                    self::getOtherRepsWizardStep(),
                    self::getResultsWizardStep(),
                ]),
            ])
            ->columns(1);
    }
}
