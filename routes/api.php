<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpleadoController;

Route::post('/empleados', [EmpleadoController::class, 'store']);
Route::apiResource('veterinarios', EmpleadoController::class);
