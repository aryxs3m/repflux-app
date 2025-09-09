<?php

use App\Http\Controllers\InviteJoinController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(\Filament\Http\Middleware\Authenticate::class)
    ->get('/join', [InviteJoinController::class, 'join'])
    ->name('invite.join');
