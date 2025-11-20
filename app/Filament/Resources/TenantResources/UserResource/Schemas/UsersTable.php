<?php

namespace App\Filament\Resources\TenantResources\UserResource\Schemas;

use App\Filament\Abstract\Schema\AbstractTableSchema;
use App\Models\User;
use App\Services\Settings\Tenant;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UsersTable extends AbstractTableSchema
{
    public static function configure(Table $table): Table
    {
        $canAdminister = Tenant::canAdminister();

        return $table
            ->description($canAdminister ? __('pages.tenancy.users.has_admin') : '')
            ->query(Tenant::getTenant()->users()->getQuery())
            ->columns([
                ImageColumn::make('avatar_url')
                    ->label('Avatar')
                    ->circular(),

                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('kick')
                    ->label(__('pages.tenancy.users.kick'))
                    ->color('danger')
                    ->icon(Heroicon::UserMinus)
                    ->visible(function (User $record) use ($canAdminister): bool {
                        return $canAdminister && $record->id !== auth()->id();
                    })
                    ->requiresConfirmation()
                    ->action(fn (User $record) => Tenant::removeUser($record)),
            ]);
    }
}
