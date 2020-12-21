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
        dump($target);
        return [$target];
    }

    public function toDiscord($notifiable)
    {
        $DiscordMessageFactory = new DiscordMessageFactory();
        $DiscordMessage = $DiscordMessageFactory->createMessage($notifiable);
        return $DiscordMessage->exportDiscordMessage();
    }

    public function toSlack($notifiable)
    {
        $SlackMessageFactory = new SlackMessageFactory();
        $SlackMessage = $SlackMessageFactory->createMessage($notifiable);
        return $SlackMessage->exportSlackMessage();
    }
}

