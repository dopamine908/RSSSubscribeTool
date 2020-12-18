<?php


namespace App\NewService\Message;


use App\NewService\RSSFeed\RSS;

abstract class AbstractFactory
{
    abstract public function createTwitterMessage(RSS $RSSItem): MessageTemplate;

    abstract public function createGithubMessage(RSS $RSSItem): MessageTemplate;

    abstract public function createYoutubeMessage(RSS $RSSItem): MessageTemplate;
}
