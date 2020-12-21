<?php


namespace App\NewService\RSSFeed;


use App\NewService\Subscribe;
use Carbon\Carbon;

class YouTube extends RSS
{
    public function __construct(Subscribe $subscribe, object $RSSSimpleXMLElementObject, object $RSSSource)
    {
        parent::__construct($subscribe, $RSSSimpleXMLElementObject, $RSSSource);
    }

    protected function initialAuthorName(): void
    {
        $this->AuthorName = $this->RSSSimpleXMLElementObject->author->name;
    }

    protected function initialAuthorAccount(): void
    {
        $this->AuthorAccount = '找不到';
    }

    protected function initialAuthorIconUrl(): void
    {
        $this->AuthorIconUrl = '找不到';
    }

    protected function initialMainPageUrl(): void
    {
        $this->MainPageUrl = $this->RSSSimpleXMLElementObject->author->uri;
    }

    protected function initialPostUrl(): void
    {
        $this->PostUrl = $this->RSSResource->link->{'@attributes'}->href;
    }

    protected function initialContent(): void
    {
        $this->Content = $this->RSSResource->title;
    }

    protected function initialPostTime(): void
    {
        $this->PostTime = new Carbon($this->RSSResource->published);
    }

    public function routeNotificationFor($driver, $notification = null)
    {
        return $this->getMessengerWebHook($this->TargetObserver);
    }
}
