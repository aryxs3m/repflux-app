<?php

namespace App\Filament\Pages;

use Filament\Actions\DeleteAction;
use Filament\Pages\Page;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Laravel\Sanctum\PersonalAccessToken;

class ApiTokens extends Page implements HasSchemas, HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament.pages.api-tokens';

    protected static bool $shouldRegisterNavigation = false;

    public function getTitle(): string|Htmlable
    {
        return __('pages.api_tokens.title');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(PersonalAccessToken::query())
            ->columns([
                TextColumn::make('created_at')
                    ->label(__('columns.created_at'))
                    ->date(),
                TextColumn::make('name')
                    ->label(__('columns.name')),
            ])
            ->recordActions([
                DeleteAction::make()
            ]);
    }
}
