<?php


namespace App\NewService\RSSFeed;


use App\NewService\Subscribe;
use Carbon\Carbon;

class Twitter extends RSS /*implements*/ /*IDiscordRouteNotification*//*, ISlackRouteNotification*/
{
    public function __construct(Subscribe $subscribe, object $RSSSimpleXMLElementObject, object $RSSSource)
    {
//        dump('start construct');
        parent::__construct($subscribe, $RSSSimpleXMLElementObject, $RSSSource);
//        dump($subscribe, $RSSSimpleXMLElementObject, $RSSSource);
    }

    protected function initialAuthorName(): void
    {
        $this->AuthorName = $this->RSSSimpleXMLElementObject->channel->title;
    }

    protected function initialAuthorAccount(): void
    {
        $this->AuthorAccount = $this->getAuthorAccount($this->RSSSimpleXMLElementObject->channel->link);
    }

    protected function initialAuthorIconUrl(): void
    {
        $this->AuthorIconUrl = $this->RSSSimpleXMLElementObject->channel->image->url;
    }

    protected function initialMainPageUrl(): void
    {
        $this->MainPageUrl = $this->RSSSimpleXMLElementObject->channel->link;
    }

    protected function initialPostUrl(): void
    {
        $this->PostUrl = $this->RSSResource->link;
    }

    protected function initialContent(): void
    {
        $this->Content = $this->RSSResource->title;
    }

    protected function initialPostTime(): void
    {
        $this->PostTime = new Carbon($this->RSSResource->pubDate);
    }

    private function getAuthorAccount($AuthorMainPageUrl): string
    {
        return collect(explode('/', $AuthorMainPageUrl))->last();
    }

//    public function routeNotificationForDiscord($notification)
//    {
//        return $this->getMessengerWebHook($this->TargetObserver);
////        return 'https://discord.com/api/webhooks/788939367208189953/Qom7o-4gLqdyxaSKJzHJbZVdGQnLevv1y141vIuZWPCukmBaFH9jCxSFY65OCMrhANbz';
//    }

    public function routeNotificationFor($driver, $notification = null)
    {
        dump($this->getMessengerWebHook($this->TargetObserver));
        return $this->getMessengerWebHook($this->TargetObserver);
//        return env('SLACK_HOOK');
    }
}
