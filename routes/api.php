<?php

use App\Http\Controllers\Api\Resources\WeightController;
use App\Http\Controllers\Api\StatusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/status', [StatusController::class, 'index']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/me', function (Request $request) {
        return $request->user();
    });

    Route::resource('weight', WeightController::class);
});
