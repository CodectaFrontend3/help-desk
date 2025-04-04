<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/{any}', function () {
    return view('welcome'); // Esto redirige cualquier ruta a Vue
})->where('any', '.*'); // La expresión regular hace que todas las rutas que no sean de Laravel se manejen por Vu
