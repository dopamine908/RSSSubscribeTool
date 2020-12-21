<?php


namespace App\NewService\Message\Discord;


use App\NewService\Message\MessageTemplate;
use App\NewService\RSSFeed\RSS;
use Awssat\Notifications\Messages\DiscordMessage;

class Youtube extends MessageTemplate implements IExportDiscordMessage
{
    const YOUTUBE_COLOR = '#FF0102';
    const YOUTUBE_ICON = 'https://i.imgur.com/0kb50h0.png';
    const YOUTUBE_THUMBNAIL_ICON = 'https://i.imgur.com/FwUCnbF.png';

    public function __construct(RSS $RSSItem)
    {
        parent::__construct($RSSItem);
    }

    public function initialMessageContent(): void
    {
        $this->MessageContent = $this->RSSItem->AuthorName . ' 有新影片';
    }

    public function initialColor(): void
    {
        $this->Color = self::YOUTUBE_COLOR;
    }

    public function initialAuthorName(): void
    {
        $this->AuthorName = $this->RSSItem->AuthorName;
    }

    public function initialAuthorMainPageUrl(): void
    {
        $this->AuthorMainPageUrl = $this->RSSItem->MainPageUrl;
    }

    public function initialTitleLeftImage(): void
    {
        $this->TitleLeftImage = self::YOUTUBE_ICON;
    }

    public function initialTitle(): void
    {
        $this->Title = 'YouTube';
    }

    public function initialTitleUrl(): void
    {
        $this->TitleUrl = $this->RSSItem->PostUrl;
    }

    public function initialTitleRightImage(): void
    {
        $this->TitleRightImage = self::YOUTUBE_THUMBNAIL_ICON;
    }

    public function initialDescription(): void
    {
        $this->Description = $this->RSSItem->Content;
    }

    public function initialFooter(): void
    {
        $this->Footer = $this->RSSItem->PostTime->toDateTimeString();
    }

    public function exportDiscordMessage(): DiscordMessage
    {
        return (new DiscordMessage)
            ->content($this->MessageContent)
            ->embed(
                function ($embed) {
                    $embed->title(
                        $this->Title,
                        $this->TitleUrl
                    )
                        ->color($this->Color)
                        ->description($this->Description)
                        ->footer($this->Footer)
                        ->author(
                            $this->AuthorName,
                            $this->AuthorMainPageUrl,
                            $this->TitleLeftImage
                        )
                        ->thumbnail(
                            $this->TitleRightImage
                        );
                }
            );
    }
}
