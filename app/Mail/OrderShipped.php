<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $text = "Nombre: {$this->user->name}\n";
        $text .= "Email: {$this->user->email}\n";
        $text .= "Creado el: {$this->user->created_at}\n";

        return $this->subject('Información del usuario')
                    ->view('empty') // Vista vacía, crea un archivo vacío resources/views/emails/empty.blade.php
                    ->withSwiftMessage(function ($message) use ($text) {
                        $message->setBody($text, 'text/plain');
                    });
    }
}
