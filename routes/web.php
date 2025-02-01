<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DisplayNotification;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\MedicationController;
// use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [RegisteredUserController::class, 'index'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::get('/login', [SessionController::class, 'index'])->name('login');
Route::post('/login', [SessionController::class, 'store']);
Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');

Route::middleware(['throttle:6,1'])->group(function () {
    Route::get('/auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback']);
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/medications', [MedicationController::class, 'index'])->name('medication');
    Route::get('/medications/{medication}', [MedicationController::class, 'show'])->name('medication.show');
    Route::post('/medications', [MedicationController::class, 'store'])->name('medication.store');
    Route::patch('/medications/{medication}', [MedicationController::class, 'update'])->name('medication.update');
    Route::delete('/medications/{medication}', [MedicationController::class, 'destroy'])->name('medication.delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/notifications', [DisplayNotification::class, 'index'])->name('notifications');
    Route::post('/notifications/{id}/mark-as-read', [DisplayNotification::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::post('/notifications/mark-all-as-read', [DisplayNotification::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::delete('/notifications/{id}', [DisplayNotification::class, 'deleteNotification'])->name('notifications.delete');
});


Route::get('/settings', function () {
    return view('pages.settings', ['user' => Auth::user()]);
})->middleware('auth');

Route::get('/schedule', [ScheduleController::class, 'index'])->middleware('auth')->name('schedule');