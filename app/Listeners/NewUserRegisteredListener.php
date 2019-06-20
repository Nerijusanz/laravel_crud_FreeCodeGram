<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Support\Facades\Mail;
use App\Mail\registerUserMail;

class NewUserRegisteredListener implements ShouldQueue
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->user;   //catch event user obj

        //queue worker should be turn on!
        //lets imagine server do something heavy process : image proccessing ...
        sleep(10); //10s    make note: do queue to database
        // after that send email
        Mail::to($user->email)->send(new registerUserMail($user));
    }
}
