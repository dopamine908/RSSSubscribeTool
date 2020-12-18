<?php


namespace App\Service;


use App\Models\RSSHistory as RSSHistoryModel;
use App\Repository\RSSHistory;
use App\Service\Notification\Discord;
use Carbon\Carbon;
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
        $this->RSSItemFactory = $RSS_item_factory;
        $this->subscribes = collect(config('rss.subscribe'));
    }

    public function execute()
    {
        $this->subscribes->each(
            function ($subscribe) {

                dump('---------------------------------------------');



                //get feed url
                $feed_url = $this->getFeedUrl($subscribe);
//                dump('-------process start------');

                dump($subscribe['type'].'-'.$subscribe['name']);

                //get all rss item
                $rss_items_original = $this->getAllRSSFeedItemOriginal($feed_url);

                //item translate : item original => RSSItem Object (factory)
                //filter item whitch want to dispatch
                $RSSItemCollection = $this->getRSSItem($rss_items_original, $subscribe);
                //generate notification
                $DiscordNotificationCollection = $this->getDiscordNotificationCollection($RSSItemCollection);

                //dispatch all notification
                $this->dispatchAllNotification($DiscordNotificationCollection);

                //update current post time
                $this->updateCurrentPostTime($DiscordNotificationCollection, $subscribe);
            }
        );
    }

    private function getFeedUrl($subscribe)
    {
        return Arr::get($subscribe, 'feed_url');
    }

    private function getAllRSSFeedItemOriginal($feed_url)
    {

        return FeedReader::read($feed_url)->get_items();
    }

    private function getRSSItem($rss_items_original, $subscribe)
    {

        $RSSHistory = new RSSHistory(new RSSHistoryModel());
        $LatestPostTime = $RSSHistory->getLatestPost($subscribe['name']);
        $rss_item = collect($rss_items_original)->filter(
            function ($rss_item) use ($subscribe, $LatestPostTime) {
                $rss_item = $this->RSSItemFactory->createRssItem($rss_item, $subscribe);
                $LatestPostTime = new Carbon($LatestPostTime->CurrentPostTime);

                return $rss_item->post_time->greaterThan($LatestPostTime);
            }
        );

        $RSSItemCollection = collect([]);
        $rss_item->each(
            function ($rss) use ($subscribe, $RSSItemCollection) {
                $RSSItemCollection->push($this->RSSItemFactory->createRssItem($rss, $subscribe));
            }
        );
        return $RSSItemCollection;
    }


    private function getDiscordNotificationCollection(Collection $RSSItemCollection)
    {
        return $RSSItemCollection->transform(
            function ($RSSItem) {
                return new Discord($RSSItem);
            }
        );
    }

    private function dispatchAllNotification(Collection $DiscordNotificationCollection)
    {
//        dump('start dispatch');
//        dump($DiscordNotificationCollection);
        dump('dispatch  ['.$DiscordNotificationCollection->count(). ']  notification');
        $DiscordNotificationCollection->each(
            function ($DiscordNotification) {
                $this->dispatch($DiscordNotification);
            }
        );
    }

    private function dispatch($DiscordNotification)
    {
//        dump($DiscordNotification->web_hook);

//dump($DiscordNotification);
        $DiscordNotification->web_hook->each(
            function ($web_hook_target) use ($DiscordNotification) {
                $response = Http::withHeaders(
                    $DiscordNotification->headers
                )->post(
//                $DiscordNotification->web_hook,
                    $web_hook_target,
                    $DiscordNotification->message
                );
                dump($response->status());
            }
        );
    }

    private function updateCurrentPostTime(Collection $DiscordNotificationCollection, $subscribe)
    {
//        dump('---------------------------------------------');

        $NotificationPostTimeCollection = $DiscordNotificationCollection->map(
            function ($Notification) {
                return $Notification->RSSItem->post_time;
            }
        );

//        dump($DiscordNotificationCollection, $NotificationPostTimeCollection);
        $LatestCurrentTime = $NotificationPostTimeCollection->first();
        $NotificationPostTimeCollection->each(
            function ($Time) use (&$LatestCurrentTime) {
                if ($Time->greaterThan($LatestCurrentTime)) {
                    $LatestCurrentTime = $Time;
                }
            }
        );

        if ($NotificationPostTimeCollection->isEmpty()) {
            $LatestCurrentTime = Carbon::now();
        }
//        dump('-------------');
//        dump($LatestCurrentTime);

        $RSSHistory = new RSSHistory(new RSSHistoryModel());
        $RSSHistory->updateCurrentTime($subscribe['name'], $LatestCurrentTime);
    }
}
