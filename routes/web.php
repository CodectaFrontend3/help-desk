<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/{any}', function () {
    return view('welcome'); // Esto redirige cualquier ruta a Vue
})->where('any', '.*'); // La expresión regular hace que todas las rutas que no sean de Laravel se manejen por Vu

Route::get('/mail', function () {
    return view('mail.send');
});

Route::post('/send', [MailController::class, 'send'])->name('send.mail');