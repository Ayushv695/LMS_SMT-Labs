<?php

namespace App\Listeners;

use App\Events\LeadConverted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LeadConvertedListener
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
     * @param  \App\Events\LeadConverted  $event
     * @return void
     */
    public function handle(LeadConverted $event)
    {
        Log::channel('lead-logs')->info('Lead status changed to converted Lead ID ='.$event->lead->id);
    }
}
