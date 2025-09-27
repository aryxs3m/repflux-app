<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\InviteJoinController;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;

Route::middleware(Authenticate::class)
    ->get('/join', [InviteJoinController::class, 'join'])
    ->name('invite.join');

Route::middleware(Authenticate::class)
    ->get('/calendar/events/{tenant}', [CalendarController::class, 'events'])
    ->name('calendar.events');

Route::redirect('/', '/app');
