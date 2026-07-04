<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Prestataire\PrestataireController;

Route::get('/', fn() => view('welcome'));

// Espace Client
use App\Http\Controllers\Client\AppointmentController;

Route::middleware(['auth', 'verified', 'role.check:client'])
    ->prefix('client')
    ->name('client.')
    ->group(function () {
        Route::get('/dashboard', [ClientController::class, 'index'])->name('dashboard');
        Route::get('/appointments', [ClientController::class, 'appointments'])->name('appointments');
        Route::get('/search', [ClientController::class, 'search'])->name('search');
        Route::get('/book/{prestataire}', [AppointmentController::class, 'create'])->name('book');
        Route::post('/book', [AppointmentController::class, 'store'])->name('book.store');
        Route::patch('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
    });

// Espace Prestataire
use App\Http\Controllers\Prestataire\ServiceController;

// Espace Prestataire
Route::middleware(['auth', 'verified', 'role.check:prestataire'])
    ->prefix('prestataire')
    ->name('prestataire.')
    ->group(function () {
        Route::get('/dashboard', [PrestataireController::class, 'index'])->name('dashboard');

        // Agenda
        Route::get('/agenda', [PrestataireController::class, 'agenda'])->name('agenda');
        Route::post('/agenda', [PrestataireController::class, 'saveAgenda'])->name('agenda.save');

        // Services
        Route::get('/services', [ServiceController::class, 'index'])->name('services');
        Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
        Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
        Route::patch('/services/{service}/toggle', [ServiceController::class, 'toggleActive'])->name('services.toggle');

        // RDV
        Route::patch('/appointments/{appointment}/confirm', [PrestataireController::class, 'confirmRdv'])->name('appointments.confirm');
        Route::patch('/appointments/{appointment}/cancel', [PrestataireController::class, 'cancelRdv'])->name('appointments.cancel');
    });

    
// Espace Admin
Route::middleware(['auth', 'verified', 'role.check:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/prestataires', [AdminController::class, 'prestataires'])->name('prestataires');
        Route::patch('/prestataires/{user}/activate', [AdminController::class, 'activate'])->name('prestataires.activate');

        Route::patch('/prestataires/{user}/activate', [AdminController::class, 'activate'])->name('prestataires.activate');
        Route::patch('/prestataires/{user}/suspend', [AdminController::class, 'suspend'])->name('prestataires.suspend');
        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');

        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
        });

require __DIR__.'/auth.php';

Route::get('/', fn() => view('welcome'));

// ← zid had bloc hna
Route::get('/dashboard', function () {
    return match(auth()->user()->role) {
        'admin'       => redirect()->route('admin.dashboard'),
        'prestataire' => redirect()->route('prestataire.dashboard'),
        default       => redirect()->route('client.dashboard'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

// Espace Client
Route::middleware(['auth', 'verified', 'role.check:client']);
// ...