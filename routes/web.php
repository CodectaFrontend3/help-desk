<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/register', [AuthController::class, 'viewRegister'])->name('register.view');

Route::get('/admin/register', [AuthController::class, 'viewRegisterAdmin'])->name('registeradmin.view');

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '^(?!api).*$');
