<?php

namespace App\Filament\Resources\TenantResources;

use App\Filament\Resources\TenantResources\UserResource\Pages\ListUsers;
use App\Models\User;
use App\Services\Settings\TenantSettings;
use Filament\Actions\Action;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static bool $shouldRegisterNavigation = false;

    protected static bool $isScopedToTenant = false;

    protected static ?string $model = User::class;

    protected static ?string $slug = 'tenant-resources/users';

    public static function getBreadcrumb(): string
    {
        return __('pages.tenancy.users.title');
    }

    public static function table(Table $table): Table
    {
        $canAdminister = TenantSettings::canAdminister();

        return $table
            ->description($canAdminister ? __('pages.tenancy.users.has_admin') : '')
            ->query(TenantSettings::getTenant()->users()->getQuery())
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
                    ->action(fn (User $record) => TenantSettings::removeUser($record)),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
        ];
    }
}
