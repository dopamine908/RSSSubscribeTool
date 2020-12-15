<?php


namespace App\Service\Notification;


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
        $this->web_hook = 'https://discord.com/api/webhooks/787959967205687306/2ZWfiat0i1wJ3GYl3aFKV6csdP4nSx78wcT9auaB1TpA1OmmpUysvPqGbRgbPDQRJS-I';
    }

    private function initialHeaders()
    {
        $this->headers = [
            'Content-Type' => 'application/json'
        ];
    }

    private function initialMessage()
    {
        $this->message = [
//            'content' => $this->RSSItem->author. ' 有一則新的貼文',
            'content' => 'TestAuthor 有一則新的貼文',
            'embeds' => [
                [
                    'title' => 'Twitter',
                    'url' => 'https://gist.github.com/Birdie0/78ee79402a4301b1faf412ab5f1cdcf9',
                    'description' => $this->RSSItem->content,
                    'color' => hexdec('#1FA1F1'),
                    'footer' => [
                        'text' =>  $this->RSSItem->post_time,
                    ],
                ],
            ],
        ];
    }
}
