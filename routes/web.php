<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/sessions', [DashboardController::class, 'store'])->name('sessions.store');
    Route::put('/sessions/{studySession}', [DashboardController::class, 'update'])->name('sessions.update');
    Route::delete('/sessions/{studySession}', [DashboardController::class, 'destroy'])->name('sessions.destroy');
    Route::post('/sessions/{studySession}/join', [DashboardController::class, 'join'])->name('sessions.join');

    Route::post('/sessions/{studySession}/attendance-bulk', [DashboardController::class, 'storeAttendanceBulk'])->name('sessions.attendance-bulk');
    Route::post('/sessions/{studySession}/rating', [DashboardController::class, 'storeRating'])->name('sessions.rating');
    Route::post('/sessions/{studySession}/completed', [DashboardController::class, 'markCompleted'])->name('sessions.completed');
    Route::post('/sessions/{studySession}/chat', [DashboardController::class, 'storeChatMessage'])->name('sessions.chat');
    Route::get('/sessions/{studySession}/download', [DashboardController::class, 'downloadMaterial'])->name('sessions.download');

    Route::post('/help-requests', [DashboardController::class, 'storeHelpRequest'])->name('help-requests.store');
    Route::put('/help-requests/{helpRequest}', [DashboardController::class, 'updateHelpRequest'])->name('help-requests.update');
    Route::delete('/help-requests/{helpRequest}', [DashboardController::class, 'destroyHelpRequest'])->name('help-requests.destroy');
    Route::get('/help-requests/{helpRequest}', [DashboardController::class, 'showHelpRequest'])->name('help-requests.show');
    Route::post('/help-requests/{helpRequest}/responses', [DashboardController::class, 'storeHelpResponse'])->name('help-requests.responses.store');
});
