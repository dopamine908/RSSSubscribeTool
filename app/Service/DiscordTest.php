<?php


namespace App\Service;


use Illuminate\Notifications\Notifiable;

class DiscordTest
{
    use Notifiable;

//    public function routeNotificationForDiscord()
//    {
////        return '788933946138034186';
//        return 'https://discord.com/api/webhooks/788939367208189953/Qom7o-4gLqdyxaSKJzHJbZVdGQnLevv1y141vIuZWPCukmBaFH9jCxSFY65OCMrhANbz';
//    }

    public function routeNotificationForDiscord($notification)
    {
        return 'https://discord.com/api/webhooks/788939367208189953/Qom7o-4gLqdyxaSKJzHJbZVdGQnLevv1y141vIuZWPCukmBaFH9jCxSFY65OCMrhANbz';
    }
}
