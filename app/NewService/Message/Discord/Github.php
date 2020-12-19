<?php


namespace App\NewService\Message\Discord;


use App\NewService\Message\MessageTemplate;
use App\NewService\RSSFeed\RSS;
use Awssat\Notifications\Messages\DiscordMessage;

class Github extends MessageTemplate implements IExportDiscordMessage
{
    const GITHUB_COLOR = '#000000';
    const GITHUB_ICON = 'https://i.imgur.com/J6LeoUb.png';

    public function __construct(RSS $RSSItem)
    {
        parent::__construct($RSSItem);
        $this->initialMessageContent();
    }

    public function initialMessageContent(): void
    {
        $this->MessageContent = '[ ' . ucfirst($this->RSSItem->AuthorAccount) . ' ] ' . $this->RSSItem->MessageContent;
    }

    public function initialColor(): void
    {
        $this->Color = self::GITHUB_COLOR;
    }

    public function initialAuthorName(): void
    {
        $this->AuthorName = '[ ' . ucfirst($this->RSSItem->AuthorAccount) . ' ] ' . $this->RSSItem->MessageContent;
    }

    public function initialAuthorMainPageUrl(): void
    {
        $this->AuthorMainPageUrl = $this->RSSItem->MainPageUrl;
    }

    public function initialTitleLeftImage(): void
    {
        $this->TitleLeftImage = self::GITHUB_ICON;
    }

    public function initialTitle(): void
    {
        $this->Title = 'Github';
    }

    public function initialTitleUrl(): void
    {
        $this->TitleUrl = $this->RSSItem->PostUrl;
    }

    public function initialTitleRightImage(): void
    {
        $this->TitleRightImage = self::GITHUB_ICON;
    }

    public function initialDescription(): void
    {
        $this->Description = '[ ' . ucfirst($this->RSSItem->AuthorAccount) . ' ] ' . $this->RSSItem->MessageContent;
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
