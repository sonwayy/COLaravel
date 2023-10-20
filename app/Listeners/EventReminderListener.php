<?php

namespace App\Listeners;

use App\Mail\EventReminderMail;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class EventReminderListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $reminderDate = Carbon::parse($event->event->date)->subDay();

        // Check if it's one day before the event
        if (Carbon::now() >= $reminderDate) {

            Mail::to($event->event->organizer->email)
                ->send(new EventReminderMail($event->event));
        }
    }
}
