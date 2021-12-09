<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SolicitudCoinAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $wallet_monto;
    public function __construct($user, $wallet_monto)
    {
        $this->user = $user;
        $this->wallet_monto = $wallet_monto;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.solicitudcoindadmin');
    }
}
