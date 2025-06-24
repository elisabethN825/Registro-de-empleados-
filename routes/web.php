<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;

Route::get('/', function () {
    return view('welcome');
});

Route::view('/empleados', [EmpleadoController::class, 'store'])->name('empleados.store');

