<?php

namespace App\Filament\Resources\TenantResources;

use App\Filament\Resources\TenantResources\UserResource\Pages\ListUsers;
use App\Filament\Resources\TenantResources\UserResource\Schemas\UsersTable;
use App\Models\User;
use Filament\Resources\Resource;
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
        return UsersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
        ];
    }
}
