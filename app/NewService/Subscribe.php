<?php


namespace App\NewService;


use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class Subscribe
{
    public $Name;
    public $Type;
    public $FeedUrl;

    /**
     * @var Collection
     */
    public $Observers;

    public function __construct(string $subscribe_key_name)
    {
        $subscribe = config('rss_notification.subscribe.' . $subscribe_key_name);
        $this->setSubscribeName($subscribe_key_name);
        $this->setType($subscribe);
        $this->setFeedUrl($subscribe);
        $this->setObservers($subscribe);
    }

    public function setType(array $subscribe): void
    {
        $this->Type = Arr::get($subscribe, 'type');
    }

    public function setFeedUrl(array $subscribe): void
    {
        $this->FeedUrl = Arr::get($subscribe, 'feed_url');
    }

    public function setObservers(array $subscribe): void
    {
        $this->Observers = collect(Arr::get($subscribe, 'observer'));
    }

    private function setSubscribeName(string $subscribe_key_name): void
    {
        $this->Name = $subscribe_key_name;
    }

    public function getObserverMessengerType($observer_name)
    {
        return config('rss_notification.observer.' . $observer_name . '.type');
    }

    public function getObserverMessengerWebHook($observer_name)
    {
        return config('rss_notification.observer.' . $observer_name . '.web_hook');

    }
}
