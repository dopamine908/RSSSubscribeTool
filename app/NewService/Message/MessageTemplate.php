<?php


namespace App\NewService\Message;


use App\NewService\RSSFeed\RSS;

abstract class MessageTemplate
{

    protected $RSSItem;

    public $MessageContent;

    /*
     * Embed
     */
    public $Color;

    public $AuthorName;
    public $AuthorMainPageUrl;

    public $Title;
    public $TitleUrl;
    public $TitleLeftImage;
    public $TitleRightImage;

    public $Description;

    public $Footer;

    public function __construct(RSS $RSSItem)
    {
        $this->RSSItem = $RSSItem;
        $this->initialMessageContent();
        $this->initialColor();
        $this->initialAuthorName();
        $this->initialAuthorMainPageUrl();
        $this->initialTitleLeftImage();
        $this->initialTitle();
        $this->initialTitleUrl();
        $this->initialTitleRightImage();
        $this->initialDescription();
        $this->initialFooter();
    }

    abstract public function initialMessageContent(): void;

    abstract public function initialColor(): void;

    abstract public function initialAuthorName(): void;

    abstract public function initialAuthorMainPageUrl(): void;

    abstract public function initialTitleLeftImage(): void;

    abstract public function initialTitle(): void;

    abstract public function initialTitleUrl(): void;

    abstract public function initialTitleRightImage(): void;

    abstract public function initialDescription(): void;

    abstract public function initialFooter(): void;

}
