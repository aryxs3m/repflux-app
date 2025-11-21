<?php

namespace App\Traits;

use App\Models\User;

trait HasUserContext
{
    protected function setUserContext(?User $user): void
    {
        if (! $user) {
            $user = auth()->user();
        }

        if (! $user) {
            return;
        }

        $this->setUserLanguage($user);
    }

    private function setUserLanguage(User $user): void
    {
        if ($user->language) {
            app()->setLocale($user->language);
        }
    }
}
