<?php

use App\Http\Controllers\MicroCompanyController;
use Illuminate\Http\Request;
use App\Http\Controllers\ClienteGController;
use App\Http\Controllers\NaturalPersonController;
use App\Http\Controllers\RegistroHardwareController;
use App\Http\Controllers\SoftwareController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\MicroEmpresaController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ContactosRefController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\HardwareController;
use App\Http\Controllers\PersonaNaturalController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\RegistroCuentasController;
use App\Http\Controllers\SoftwareEquipoController;
use Illuminate\Support\Facades\Route;

Route::get('/micro-company', [MicroCompanyController::class, "index"]);
Route::get('/micro-company/{id}', [MicroCompanyController::class, "show"]);
Route::post('/micro-company', [MicroCompanyController::class, "store"]);
Route::put('/micro-company/{id}', [MicroCompanyController::class, "update"]);
Route::delete('/micro-company/{id}', [MicroCompanyController::class, "destroy"]);

Route::get('/natural-person', [NaturalPersonController::class, "index"]);
Route::get('/natural-person/{id}', [NaturalPersonController::class, "show"]);
Route::post('/natural-person', [NaturalPersonController::class, "store"]);
Route::put('/natural-person/{id}', [NaturalPersonController::class, "update"]);
Route::delete('/natural-person/{id}', [NaturalPersonController::class, "destroy"]);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/clienteG', ClienteGController::class);
Route::apiResource('/registroHardware', RegistroHardwareController::class);
Route::apiResource('/software', SoftwareController::class);

//Tablas inferiores
Route::apiResource('empresa', EmpresaController::class);
Route::apiResource('microempresa', MicroEmpresaController::class);
Route::apiResource('sucursal', SucursalController::class);
Route::apiResource('area', AreaController::class);
Route::apiResource('contactosRef', ContactosRefController::class);
Route::apiResource('/personaNatural', PersonaNaturalController::class);

Route::apiResource('/planes', PlanController::class);
Route::apiResource('/hardware', HardwareController::class);
Route::apiResource('/registroCuenta', RegistroCuentasController::class);
Route::apiResource('/equipo', EquipoController::class);
Route::apiResource('/softwareEquipo', SoftwareEquipoController::class);