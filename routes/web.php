<?php

use Illuminate\Support\Facades\Route;

Use App\Http\Controllers\ZipCodeController;

Route::resource('/', ZipCodeController::class);
