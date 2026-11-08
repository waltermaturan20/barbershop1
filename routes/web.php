<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LogInController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceCategoryController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\BarberController;
use App\Http\Controllers\Admin\AppointmentController;

Route::get('/', [LandingController::class, 'landing'])->name('landing');
Route::get('/login', [LogInController::class, 'login'])->name('login');
Route::post('/login', [LogInController::class, 'authenticate'])->name('login.authenticate');
Route::post('/logout', [LogInController::class, 'logout'])->name('logout');
Route::get('/register', [LogInController::class, 'register'])->name('register');
Route::post('/register', [LogInController::class, 'registerStore'])->name('register.store');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::get('/service-categories', [ServiceCategoryController::class, 'index'])->name('service-categories');
    Route::post('/service-categories', [ServiceCategoryController::class, 'store'])->name('service-categories.store');
    Route::put('/service-categories/{serviceCategory}', [ServiceCategoryController::class, 'update'])->name('service-categories.update');
    Route::delete('/service-categories/{serviceCategory}', [ServiceCategoryController::class, 'destroy'])->name('service-categories.destroy');

    Route::get('/services', [ServiceController::class, 'index'])->name('services');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

    Route::get('/clients', [ClientController::class, 'index'])->name('clients');
    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::put('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');

    Route::get('/barbers', [BarberController::class, 'index'])->name('barbers');
    Route::post('/barbers', [BarberController::class, 'store'])->name('barbers.store');
    Route::put('/barbers/{barber}', [BarberController::class, 'update'])->name('barbers.update');
    Route::delete('/barbers/{barber}', [BarberController::class, 'destroy'])->name('barbers.destroy');

    Route::get('/schedule', [AppointmentController::class, 'index'])->name('schedule');
    Route::post('/schedule', [AppointmentController::class, 'store'])->name('schedule.store');
    Route::put('/schedule/{appointment}', [AppointmentController::class, 'update'])->name('schedule.update');
    Route::patch('/schedule/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('schedule.status');
    Route::delete('/schedule/{appointment}', [AppointmentController::class, 'destroy'])->name('schedule.destroy');
});
