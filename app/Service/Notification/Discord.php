<?php


namespace App\Service\Notification;


use App\Service\Message\MessageFactory;
use App\Service\RSSFeed\RSSItem;

class Discord
{
    private $RSSItem;
    public $web_hook;
    public $headers;
    public $message;

    public function __construct(RSSItem $RSS_item)
    {
        $this->RSSItem = $RSS_item;
        $this->initialWebHook();
        $this->initialHeaders();
        $this->initialMessage();
    }

    private function initialWebHook()
    {
//        $this->web_hook = 'https://discord.com/api/webhooks/787959967205687306/2ZWfiat0i1wJ3GYl3aFKV6csdP4nSx78wcT9auaB1TpA1OmmpUysvPqGbRgbPDQRJS-I';
        $this->web_hook = config('rss.notify.discord.web_hook');
    }

    private function initialHeaders()
    {
        $this->headers = [
            'Content-Type' => 'application/json'
        ];
    }

    private function initialMessage()
    {


        $MessageFactory = new MessageFactory();

//        dump($MessageFactory->createMessage($this->RSSItem, 'Discord'));
        $this->message = $MessageFactory->createDiscordMessage($this->RSSItem);
//        dump($this->message);
    }
}
