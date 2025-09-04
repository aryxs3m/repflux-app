<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProgressionResource\Pages;
use App\Models\RecordType;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class ProgressionResource extends Resource
{
    protected static ?string $model = RecordType::class;

    protected static ?string $slug = 'progression';

    protected static ?string $breadcrumb = 'Progression';

    protected static string | UnitEnum | null $navigationGroup = 'Reports';
    protected static ?string $navigationLabel = 'Progression';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentChartBar;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('recordCategory.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProgression::route('/'),
            'view' => Pages\ViewProgression::route('/view/{record}'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}
