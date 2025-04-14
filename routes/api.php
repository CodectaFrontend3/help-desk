<?php

use App\Http\Controllers\ClienteGController;
use App\Http\Controllers\HardwareController;
use App\Http\Controllers\RegistroHardwareController;
use App\Http\Controllers\SoftwareController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/clienteG',ClienteGController::class);
Route::apiResource('/registroHardware',RegistroHardwareController::class);
Route::apiResource('/software',SoftwareController::class);
Route::apiResource('/hardware',HardwareController::class);
