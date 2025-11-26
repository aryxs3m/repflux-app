<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\InviteJoinController;
use App\Http\Controllers\PwaShortcutController;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

Route::middleware(Authenticate::class)
    ->group(function () {
        Route::get('/join', [InviteJoinController::class, 'join'])
            ->name('invite.join');

        Route::get('/calendar/events/{tenant}', [CalendarController::class, 'events'])
            ->name('calendar.events');

        Route::get('/shortcut/weights/create', [PwaShortcutController::class, 'newWeightMeasurement'])
            ->name('pwa-shortcut.new-weight-measurement');

        Route::get('/shortcut/record-sets/create', [PwaShortcutController::class, 'newRecordSet'])
            ->name('pwa-shortcut.new-record-set');
    });

Route::redirect('/', '/app');
