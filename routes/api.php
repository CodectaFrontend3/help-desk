<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\MicroCompanyController;
use Illuminate\Http\Request;
use App\Http\Controllers\ClienteGController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\NaturalPersonController;
use App\Http\Controllers\RegistroHardwareController;
use App\Http\Controllers\SoftwareController;

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
Route::apiResource('/software', SoftwareController::class);
