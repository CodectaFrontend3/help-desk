<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;  
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\MailRequest;
use App\Mail\OrderShipped;

class MailController extends Controller
{
   public function send(MailRequest $request)
    {
        $validated = $request->validated();

        // Crea el usuario con los datos validados
        $user = \App\Models\User::create($validated);

        // Envía el correo al email del usuario
        Mail::to($user->email)->send(new OrderShipped($user));

        return 'Correo enviado correctamente.';
    }
}
