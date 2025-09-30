<?php

namespace App\Filament\Resources\RecordCategoryResource\Schemas;

use App\Filament\AbstractFormSchema;
use App\Models\RecordCategory;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class RecordCategoryForm extends AbstractFormSchema
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),

                TextEntry::make('created_at')
                    ->label('Created Date')
                    ->state(fn (?RecordCategory $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                TextEntry::make('updated_at')
                    ->label('Last Modified Date')
                    ->state(fn (?RecordCategory $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ]);
    }
}
