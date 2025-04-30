<?php

use App\Http\Controllers\AccountRegisterController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\MicroCompanyController;
use Illuminate\Http\Request;
use App\Http\Controllers\ClienteGController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\NaturalPersonController;
use App\Http\Controllers\RegistroHardwareController;
use App\Http\Controllers\SoftwareController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\MicroEmpresaController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ClientGController;
use App\Http\Controllers\ContactosRefController;
use App\Http\Controllers\CuentaTrabajadorController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\HardwareController;
use App\Http\Controllers\PersonaNaturalController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\RegisterHardwareController;
use App\Http\Controllers\RegistroCuentasController;
use App\Http\Controllers\SoftwareEquipoController;
use Illuminate\Support\Facades\Route;

Route::apiResource('/micro-company', MicroCompanyController::class);
Route::apiResource('/natural-person', NaturalPersonController::class);
Route::apiResource('/company', CompanyController::class);
Route::apiResource('/branch', BranchController::class);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/clienteG', ClienteGController::class);
Route::apiResource('/registroHardware', RegistroHardwareController::class);

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
Route::apiResource('/cuentaTrabajador', CuentaTrabajadorController::class);

//routes en ingles
Route::apiResource('/clientG', ClientGController::class);
Route::apiResource('/registerHardware', RegisterHardwareController::class);
Route::apiResource('/plan', PlanController::class);
Route::apiResource('/software', SoftwareController::class);
Route::apiResource('/accountRegister', AccountRegisterController::class);
Route::apiResource('micro_company', MicroCompanyController::class);
Route::apiResource('company', CompanyController::class);
Route::apiResource('natural-person', NaturalPersonController::class);