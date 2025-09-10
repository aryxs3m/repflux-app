<?php

namespace App\Providers;

use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentAsset::register([
            Css::make('css', \Vite::useHotFile('hot')
                ->asset('resources/scss/app.css', 'build')),
            Js::make('js', \Vite::useHotFile('hot')
                ->asset('resources/js/app.js', 'build')),
        ]);
    }
}
