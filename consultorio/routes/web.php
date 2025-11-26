<?php

use App\Http\Controllers\ConsultasController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\marvin_controller;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CitaController;

Route::resource('usuarios', UserController::class);
Route::get('/citas', [CitaController::class, 'index'])->name('citas.index');
    Route::post('/citas', [CitaController::class, 'store'])->name('citas.store');
    Route::delete('/citas/{cita}', [CitaController::class, 'destroy'])->name('citas.destroy');

Route::get('/doctor/citas', [CitaController::class, 'indexDoctor'])->name('doctor.citas');
Route::patch('/doctor/citas/{cita}/confirmar', [CitaController::class, 'confirmar'])->name('doctor.citas.confirmar');
Route::delete('/doctor/citas/{cita}/cancelar', [CitaController::class, 'cancelarDoctor'])->name('doctor.citas.cancelar');

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('/importar_excel', [marvin_controller::class, 'importar_excel'])->name('importar_excel');
    Route::post('/import_excel', [marvin_controller::class, 'import_excel'])->name('import_excel');

    // Consulta de pacientes
    Route::get('/consulta', [ConsultasController::class, 'index'])->name('consulta');
    Route::post('/receta', [ConsultasController::class, 'guardarReceta'])->name('guardar.receta');

    Route::post('/crearPaciente', [UserController::class, 'creaPaciente'])->name('guardar.paciente');

    Route::get('/historial', [HistorialController::class, 'index'])->name('historial.index');
    Route::get('/historial/{paciente}', [HistorialController::class, 'show'])->name('historial.show');
    Route::put('/historial/{historial}', [HistorialController::class, 'update'])->name('historial.actualizar');
    Route::delete('/historial/{historial}/image', [HistorialController::class, 'deleteImage'])->name('historial.eliminarImagen');
    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
