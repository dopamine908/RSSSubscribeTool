<?php


namespace App\Service;


use Illuminate\Notifications\Notifiable;

class SlackTest
{
    use Notifiable;

    public function routeNotificationFor($driver, $notification = null)
    {
        return env('SLACK_HOOK');
    }


}
