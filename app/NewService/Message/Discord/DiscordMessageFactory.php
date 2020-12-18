<?php


namespace App\NewService\Message\Discord;


use App\NewService\Message\AbstractFactory;
use App\NewService\Message\MessageTemplate;
use App\NewService\RSSFeed\RSS;
use Awssat\Notifications\Messages\DiscordMessage;

class DiscordMessageFactory extends AbstractFactory
{


    public function createTwitterMessage(RSS $RSSItem): MessageTemplate
    {
        return new Twitter($RSSItem);
    }

    public function createGithubMessage(RSS $RSSItem): MessageTemplate
    {
        // TODO: Implement createGithubMessage() method.
    }

    public function createYoutubeMessage(RSS $RSSItem): MessageTemplate
    {
        // TODO: Implement createYoutubeMessage() method.
    }

    public function createMessage(RSS $RSSItem):IExportDiscordMessage
    {
        $subscribe_type=$RSSItem->getSubscribeType();
        switch ($subscribe_type){
            case 'Twitter':
                $Message=$this->createTwitterMessage($RSSItem);
                break;
        }
//        dump($Message);
        return $Message;
    }
}
