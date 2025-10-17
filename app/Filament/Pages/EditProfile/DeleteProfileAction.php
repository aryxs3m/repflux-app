<?php

namespace App\Filament\Pages\EditProfile;

use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;

class DeleteProfileAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->name('delete-profile');
        $this->label('Delete profile');
        $this->icon(Heroicon::OutlinedTrash);
        $this->color('danger');
        $this->requiresConfirmation();
        $this->action(function () {
            auth()->user()->delete();
            $this->redirect('/', false);
        });
    }
}
