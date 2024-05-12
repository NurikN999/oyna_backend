<?php

namespace App\Listeners;

use App\Events\UserDeleted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class InvalidateUserToken
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
    public function handle(UserDeleted $event): void
    {
        $user = $event->user;
        foreach ($user->tokens as $token) {
            $token->revoke();
        }
    }
}
