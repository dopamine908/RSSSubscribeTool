<?php


namespace App\NewService\RSSFeed;


use App\NewService\Subscribe;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class Github extends RSS
{
    public function __construct(Subscribe $subscribe, object $RSSSimpleXMLElementObject, object $RSSSource)
    {
        parent::__construct($subscribe, $RSSSimpleXMLElementObject, $RSSSource);
        $this->initialMessageContent();
    }

    public function initialMessageContent(): void
    {
        $this->MessageContent = $this->RSSSimpleXMLElementObject->title . ' : ' . $this->RSSResource->title;
    }

    protected function initialAuthorName(): void
    {
        $this->AuthorName = Arr::get(explode('/', $this->RSSSimpleXMLElementObject->link[0]->{'@attributes'}->href), 3);
    }

    protected function initialAuthorAccount(): void
    {
        $this->AuthorAccount = Arr::get(
            explode('/', $this->RSSSimpleXMLElementObject->link[0]->{'@attributes'}->href),
            3
        );
    }

    protected function initialAuthorIconUrl(): void
    {
        $this->AuthorIconUrl = '找不到';
    }

    protected function initialMainPageUrl(): void
    {
        $this->MainPageUrl = $this->RSSSimpleXMLElementObject->link[0]->{'@attributes'}->href;
    }

    protected function initialPostUrl(): void
    {
        $this->PostUrl = $this->RSSResource->link->{'@attributes'}->href;
    }

    protected function initialContent(): void
    {
        $this->Content = $this->RSSResource->content;
    }

    protected function initialPostTime(): void
    {
        $this->PostTime = new Carbon($this->RSSResource->updated);
    }

    public function routeNotificationFor($driver, $notification = null)
    {
        return $this->getMessengerWebHook($this->TargetObserver);
    }
}
