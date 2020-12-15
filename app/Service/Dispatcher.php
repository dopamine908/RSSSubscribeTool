<?php


namespace App\Service;


use App\Service\Notification\Discord;
use App\Service\RSSFeed\Github;
use App\Service\RSSFeed\Nitter;
use App\Service\RSSFeed\RSSItem;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Vedmant\FeedReader\Facades\FeedReader;

class Dispatcher
{
    private $subscribes;
private $RSSItemFactory;
    public function __construct(RSSItemFactory $RSS_item_factory)
    {
        $this->RSSItemFactory=$RSS_item_factory;
        $this->subscribes = collect(config('rss.subscribe'));
    }

    public function execute()
    {
        $this->subscribes->each(
            function ($subscribe) {
                //get feed url
                $feed_url = $this->getFeedUrl($subscribe);

                //get all rss item
                $rss_items_original = $this->getAllRSSFeedItemOriginal($feed_url);

                //item translate : item original => RSSItem Object (factory)
                //filter item whitch want to dispatch
                $RSSItem = $this->getRSSItem($rss_items_original, $subscribe);

                //generate notification
                $DiscordNotificationCollection = $this->getDiscordNotificationCollection($RSSItem);

                //dispatch all notification
                $this->dispatchAllNotification($DiscordNotificationCollection);
            }
        );
    }

    private function getFeedUrl($subscribe)
    {
        return Arr::get($subscribe, 'feed_url');
    }

    private function getAllRSSFeedItemOriginal($feed_url)
    {
//        dump(FeedReader::read($feed_url));
//        dump(FeedReader::read($feed_url)->get_items());
//        exit();
        return FeedReader::read($feed_url)->get_items();
    }

    private function getRSSItem($rss_items_original, $subscribe): RSSItem
    {
//        dump($rss_items_original);
//        exit();
        $rss_item = $rss_items_original[0];
//        dump($rss_item);
        dump($subscribe['type']);

        $RSSItem=$this->RSSItemFactory->createRssItem($rss_item, $subscribe);
        dump($RSSItem);
//        exit();
//        $RSSItem = new Nitter($rss_item);
        return $RSSItem;
    }


    private function getDiscordNotificationCollection(RSSItem $RSSItem)
    {
        return collect([new Discord($RSSItem)]);
    }

    private function dispatchAllNotification(Collection $DiscordNotificationCollection)
    {
        $DiscordNotificationCollection->each(
            function ($DiscordNotification) {
                $this->dispatch($DiscordNotification);
            }
        );
    }

    private function dispatch($DiscordNotification)
    {
        $response = Http::withHeaders(
            $DiscordNotification->headers
        )->post(
            $DiscordNotification->web_hook,
            $DiscordNotification->message
        );
        dump($response->status());
        dump($response->successful());
    }
}
