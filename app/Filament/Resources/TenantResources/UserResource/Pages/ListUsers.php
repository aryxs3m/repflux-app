<?php

namespace App\Filament\Resources\TenantResources\UserResource\Pages;

use App\Filament\Resources\TenantResources\UserResource;
use App\Services\InvitationService;
use App\Services\Settings\Tenant;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('pages.tenancy.users.title');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('invite')
                ->label(__('pages.tenancy.users.invite'))
                ->visible(Tenant::canAdminister())
                ->icon(Heroicon::UserPlus)
                ->color('success')
                ->schema([
                    TextInput::make('email')
                        ->email()
                        ->required(),
                ])
                ->action(function (array $data): void {
                    try {
                        app(InvitationService::class)->inviteByEmail(Tenant::getTenant(), $data['email']);

                        Notification::make()
                            ->title(__('pages.tenancy.users.notifications.invitation.success.title'))
                            ->body(__('pages.tenancy.users.notifications.invitation.success.body'))
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        logger()->error('Failed to invite user.', [
                            'form' => $data,
                            'exception' => $e,
                        ]);

                        Notification::make()
                            ->title(__('pages.tenancy.users.notifications.invitation.fail.title'))
                            ->body(__('pages.tenancy.users.notifications.invitation.fail.body'))
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }
}
