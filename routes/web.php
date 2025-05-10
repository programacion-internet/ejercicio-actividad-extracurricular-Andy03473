<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\ArchivoController;


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';


Route::get('/inicio', [EventoController::class, 'index'])->name('eventos.inicio');
Route::post('/eventos/{evento}/inscribirse', [EventoController::class, 'inscribirse'])->middleware('auth')->name('eventos.inscribirse');

Route::post('/archivos', [ArchivoController::class, 'store'])->middleware('auth')->name('archivos.store');
Route::delete('/archivos/{archivo}', [ArchivoController::class, 'destroy'])->middleware('auth')->name('archivos.destroy');
Route::post('/eventos/{evento}/inscribirse', [EventoController::class, 'inscribirse'])
    ->middleware('auth')
    ->name('eventos.inscribirse');
Route::get('/mis-cursos', [App\Http\Controllers\EventoController::class, 'misCursos'])->middleware('auth')->name('eventos.misCursos');
Route::get('/mis-cursos', [EventoController::class, 'misCursos'])->name('eventos.mis_cursos');
Route::get('/eventos/create', [EventoController::class, 'create'])->name('eventos.create');
Route::resource('eventos', EventoController::class);