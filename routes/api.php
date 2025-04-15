<?php

use App\Http\Controllers\MicroCompanyController;
use Illuminate\Http\Request;
use App\Http\Controllers\ClienteGController;
use App\Http\Controllers\NaturalPersonController;
use App\Http\Controllers\RegistroHardwareController;
use App\Http\Controllers\SoftwareController;

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
