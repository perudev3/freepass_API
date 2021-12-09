<?php

namespace App\Listeners;

use App\Events\ReservasStatusChangedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ReservasStatusListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ReservasStatusChangedEvent  $event
     * @return void
     */
    public function handle(ReservasStatusChangedEvent $event)
    {
        //
    }
}
