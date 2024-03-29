<?php

use Illuminate\Support\Facades\Route;

Use App\Http\Controllers\ZipCodeController;

// Ruta para mostrar el formulario
Route::get('/', [ZipCodeController::class, 'index'])->name('zipcode.index');

// Ruta para manejar la solicitud POST desde el formulario
Route::post('/consultar-api', [ZipCodeController::class, 'store'])->name('zipcode.store');

// Ruta para mostrar el resultado
Route::get('/mostrar-resultado/{zipCode}', [ZipCodeController::class, 'show'])->name('zipcode.show');

// Ruta para mostrar posibles errores
Route::get('/error', [ErrorController::class, 'index'])->name('error');