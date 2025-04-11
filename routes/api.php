<?php

use App\Http\Controllers\RegistroHardwareController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('/registroHardware',RegistroHardwareController::class);
