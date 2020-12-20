<?php


namespace App\NewService\Message\Slack;


use App\NewService\Message\AbstractFactory;
use App\NewService\Message\MessageTemplate;
use App\NewService\RSSFeed\RSS;

class SlackMessageFactory extends AbstractFactory
{

    public function createTwitterMessage(RSS $RSSItem): MessageTemplate
    {
        return new Twitter($RSSItem);
    }

    public function createGithubMessage(RSS $RSSItem): MessageTemplate
    {
        return new Github($RSSItem);
    }

    public function createYoutubeMessage(RSS $RSSItem): MessageTemplate
    {
        // TODO: Implement createYoutubeMessage() method.
    }

    public function createMessage(RSS $RSSItem): IExportSlackMessage
    {
        $subscribe_type = $RSSItem->getSubscribeType();
        switch ($subscribe_type) {
            case 'Twitter':
                $Message = $this->createTwitterMessage($RSSItem);
                break;
            case 'Github':
                $Message = $this->createGithubMessage($RSSItem);
                break;
        }
//        dump($Message);
        return $Message;
    }

}
