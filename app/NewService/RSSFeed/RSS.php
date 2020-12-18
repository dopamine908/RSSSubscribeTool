<?php


namespace App\NewService\RSSFeed;


use App\NewService\Subscribe;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

abstract class RSS
{
    use Notifiable;

    public $Subscribe;
    public $RSSSimpleXMLElementObject;
    public $RSSResource;
    public $TargetObserver;

    public $MessageContent;

    /*
     * Embed
     */

    public $AuthorName;
    public $AuthorAccount;
//    public $AuthorMainPageUrl;
    public $AuthorIconUrl;

//    public $Title;
//    public $TitleUrl;
//    public $TitleRightImage;
    public $MainPageUrl;
    public $PostUrl;

    public $Content;

//    public $Footer;
    public $PostTime;

    public function __construct(Subscribe $subscribe, object $RSSSimpleXMLElementObject, object $RSSSource)
    {
        $this->Subscribe = $subscribe;
        $this->RSSSimpleXMLElementObject = $RSSSimpleXMLElementObject;
        $this->RSSResource = $RSSSource;
        $this->initialAuthorName();
        $this->initialAuthorAccount();
        $this->initialAuthorIconUrl();
        $this->initialMainPageUrl();
        $this->initialPostUrl();
        $this->initialContent();
        $this->initialPostTime();
    }

    abstract protected function initialAuthorName(): void;

    abstract protected function initialAuthorAccount(): void;

    abstract protected function initialAuthorIconUrl(): void;

    abstract protected function initialMainPageUrl(): void;

    abstract protected function initialPostUrl(): void;

    abstract protected function initialContent(): void;

    abstract protected function initialPostTime(): void;

    public function getSubscribeName(): string
    {
        return $this->Subscribe->Name;
    }

    public function getObservers(): Collection
    {
        return $this->Subscribe->Observers;
    }

    public function getMessengerType(string $observer_name): string
    {
        return $this->Subscribe->getObserverMessengerType($observer_name);
    }

    public function getMessengerWebHook(string $observer_name): string
    {
        return $this->Subscribe->getObserverMessengerWebHook($observer_name);
    }

    public function setTargetObserver(string $observer_name)
    {
        $this->TargetObserver = $observer_name;
    }

    public function getSubscribeType():string{return $this->Subscribe->Type;}
}
