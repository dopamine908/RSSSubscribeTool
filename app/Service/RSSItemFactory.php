<?php


namespace App\Service;


use App\Service\RSSFeed\Github;
use App\Service\RSSFeed\Nitter;

class RSSItemFactory
{

    public function createRssItem($rss_item, $subscribe)
    {
        switch ($subscribe['type']) {
            case 'Nitter';
                $RSSItem = new Nitter($rss_item, $subscribe['observer']);
                break;
            case 'Github';
                $RSSItem = new Github($rss_item, $subscribe['observer']);
                break;
        }
        return $RSSItem;
    }
}
