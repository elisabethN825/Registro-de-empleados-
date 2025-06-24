<?php

use Illuminate\Http\Request;
use App\Http\Controllers\EmpleadoController;

Route::post('/empleados', [EmpleadoController::class, 'store']);
Route::apiResource('veterinarios', EmpleadoController::class);
