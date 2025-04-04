<?php

use App\Http\Controllers\MicroCompanyController;
use App\Models\MicroCompany;
use Illuminate\Database\Query\IndexHint;
use Illuminate\Support\Facades\Route;

Route::get('/micro-company',[MicroCompanyController::class, "index"]);
Route::get('/micro-company/{id}',[MicroCompanyController::class, "show"]);
Route::post('/micro-company',[MicroCompanyController::class, "store"]);
Route::put('/micro-company/{id}',[MicroCompanyController::class, "update"]);
Route::delete('/micro-company/{id}',[MicroCompanyController::class, "destroy"]);
