<?php

use App\Http\Controllers\AccountRegisterController;
use App\Http\Controllers\AccountWorkerController;
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
use App\Http\Controllers\SoftwareTeamController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactRefController;
use App\Http\Controllers\TicketController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//routes en ingles
Route::apiResource('/clientG', ClientGController::class);
Route::apiResource('/registerHardware', RegisterHardwareController::class);
Route::apiResource('/plan', PlanController::class);
Route::apiResource('/software', SoftwareController::class);
Route::apiResource('/accountRegister', AccountRegisterController::class);
Route::apiResource('/micro_company', MicroCompanyController::class);
Route::apiResource('/company', CompanyController::class);
Route::apiResource('/natural-person', NaturalPersonController::class);
Route::apiResource('/team', TeamController::class);
Route::apiResource('/hardware', HardwareController::class);
Route::apiResource('/softwareTeam', SoftwareTeamController::class);
Route::apiResource('/accountWorker', AccountWorkerController::class);
Route::apiResource('/branches', BranchController::class);
Route::resource('/areas', AreaController::class);
Route::resource('/contact_refs', ContactRefController::class);
Route::apiResource('/tickets', TicketController::class);