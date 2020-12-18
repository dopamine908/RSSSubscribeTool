<?php

namespace App\Notifications;

use Awssat\Notifications\Messages\DiscordMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;


class DiscordNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['discord'];
    }


    public function toDiscord($notifiable)
    {
        // github
        return (new DiscordMessage)
            ->content('Larave new release -> version : v8.19')

            ->embed(
                function ($embed) {
                    $embed->title(
                        'Laravel new release -> version : v8.19',
                        'https://laravel.com/docs/8.x/notifications#slack-notifications'
                    )
                        ->color('#000000')
//                        ->description('release version : v8.19')
                        ->footer('2020.12.20')
                        ->author(
                            'Github',
                            'https://laravel.com/docs/8.x/notifications#slack-notifications',
                            'https://i.imgur.com/J6LeoUb.png'
                        )->thumbnail('https://i.imgur.com/amdNpxG.jpeg');
                }
            );

        //twitter
//        return (new DiscordMessage)
//            ->content('Taylor Otwell ⛵️ / @taylorotwell 有一則新的貼文')
//            ->embed(
//                function ($embed) {
//                    $embed->title(
//                        'Twitter',
//                        'https://laravel.com/docs/8.x/notifications#slack-notifications'
//                    )
//                        ->color('#1FA1F1')
//                        ->description('post content')
//                        ->footer('2020.12.20')
//                        ->author(
//                            'Taylor Otwell ⛵️ / @taylorotwell',
//                            'https://laravel.com/docs/8.x/notifications#slack-notifications',
//                            'https://i.imgur.com/LS08Auh.png'
//                        )
//                    ->thumbnail( 'https://nitter.net/pic/profile_images%2F914894066072113152%2FpWD-GUwG_400x400.jpg');
//                }
//            );

        //Yoututbe
        return (new DiscordMessage)
            ->content('HowFun 有新的影片')
            ->embed(
                function ($embed) {
                    $embed->color('#FF0102')
                        ->author(
                            'HowFun',
                            'https://laravel.com/docs/8.x/notifications#slack-notifications',
                            'https://i.imgur.com/0kb50h0.png'
                        )->title(
                            'Youtube',
                            'https://laravel.com/docs/8.x/notifications#slack-notifications'
                        )
                        ->thumbnail('https://i.imgur.com/FwUCnbF.png')
                        ->description('哇！珍妮佛羅培孜！')
                        ->footer('2020.12.20');
                }
            );
    }


    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
