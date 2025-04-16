<?php

use App\Http\Controllers\MicroCompanyController;
use Illuminate\Http\Request;
use App\Http\Controllers\ClienteGController;
use App\Http\Controllers\RegistroCuentasController;
use App\Http\Controllers\RegistroHardwareController;
use App\Http\Controllers\SoftwareController;

use Illuminate\Support\Facades\Route;

Route::get('/micro-company', [MicroCompanyController::class, "index"]);
Route::get('/micro-company/{id}', [MicroCompanyController::class, "show"]);
Route::post('/micro-company', [MicroCompanyController::class, "store"]);
Route::put('/micro-company/{id}', [MicroCompanyController::class, "update"]);
Route::delete('/micro-company/{id}', [MicroCompanyController::class, "destroy"]);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/clienteG', ClienteGController::class);
Route::apiResource('/registroHardware', RegistroHardwareController::class);
Route::apiResource('/software', SoftwareController::class);
Route::apiResource('/registroCuenta', RegistroCuentasController::class);
