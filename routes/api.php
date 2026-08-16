<?php

use App\Http\Controllers\Api\InternalApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| These routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group.
|
*/

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/competitions/{competition}/talents', [InternalApiController::class, 'competitionTalents'])
        ->name('api.competitions.talents');

    Route::get('/notifications/unread-count', [InternalApiController::class, 'unreadNotificationCount'])
        ->name('api.notifications.unread-count');

    Route::post('/notifications/{notification}/mark-read', [InternalApiController::class, 'markNotificationRead'])
        ->name('api.notifications.mark-read');

    Route::get('/notifications/list', [InternalApiController::class, 'listNotifications'])
        ->name('api.notifications.list');
});
