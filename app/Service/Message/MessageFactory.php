<?php


namespace App\Service\Message;


use App\Service\Message\Discord\Github;
use App\Service\Message\Discord\Twitter;
use App\Service\RSSFeed\RSSItem;

class MessageFactory
{
    public function createDiscordMessage(RSSItem $RSS_item)
    {

        switch ($RSS_item->source) {
            case 'Github';
                $Message = new Github();
                break;
            case 'Twitter';
                $Message = new Twitter();

                break;
        }
        return $Message->getTemplateContent($RSS_item);
    }
}
