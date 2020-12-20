<?php

namespace App\Notifications;

use App\NewService\Message\Discord\DiscordMessageFactory;
use App\NewService\Message\Slack\SlackMessageFactory;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class MessengerNotification extends Notification
{
    use Queueable;

    private $Observer;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $observer)
    {
        $this->Observer = $observer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
//        dump($notifiable->getMessengerType($this->Observer));
        $target = Str::lower($notifiable->getMessengerType($this->Observer));
//dump($target);
        return [$target];
    }

    public function toDiscord($notifiable)
    {
        $DiscordMessageFactory = new DiscordMessageFactory();
        $DiscordMessage = $DiscordMessageFactory->createMessage($notifiable);
        return $DiscordMessage->exportDiscordMessage();
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
//                        ->thumbnail(
//                            'https://nitter.net/pic/profile_images%2F914894066072113152%2FpWD-GUwG_400x400.jpg'
//                        );
//                }
//            );
    }

    public function toSlack($notifiable)
    {
        $SlackMessageFactory = new SlackMessageFactory();
        $SlackMessage = $SlackMessageFactory->createMessage($notifiable);
        return $SlackMessage->exportSlackMessage();
    }
}

