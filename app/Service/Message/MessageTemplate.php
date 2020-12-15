<?php


namespace App\Service\Message;


use App\Service\RSSFeed\RSSItem;

abstract class MessageTemplate
{
abstract function getTemplateContent(RSSItem $RSS_item);
}
