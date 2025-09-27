<?php

namespace App\Filament\Pages;

use Filament\Auth\Pages\Login;
use Filament\Schemas\Components\Component;

class LoginPage extends Login
{
    protected function getEmailFormComponent(): Component
    {
        if (config('app.demo.enabled')) {
            return parent::getEmailFormComponent()
                ->default(config('app.demo.email'));
        }

        return parent::getEmailFormComponent();
    }

    protected function getPasswordFormComponent(): Component
    {
        if (config('app.demo.enabled')) {
            return parent::getPasswordFormComponent()
                ->default(config('app.demo.password'));
        }

        return parent::getPasswordFormComponent();
    }
}
