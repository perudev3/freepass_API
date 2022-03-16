<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailRegisterUser extends Mailable
{
    use Queueable, SerializesModels;

    public $codigo_activacion;


    public function __construct($codigo_activacion)
    {
        $this->codigo_activacion =$codigo_activacion;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.activacion');
    }
}
