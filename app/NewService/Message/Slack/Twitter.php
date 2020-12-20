<?php


namespace App\NewService\Message\Slack;


use App\NewService\Message\MessageTemplate;
use App\NewService\RSSFeed\RSS;
use Illuminate\Notifications\Messages\SlackMessage;

class Twitter extends MessageTemplate implements IExportSlackMessage
{
    const TWITTER_COLOR = '#1FA1F1';
    const TWITTER_ICON = 'https://i.imgur.com/LS08Auh.png';

    public function __construct(RSS $RSSItem)
    {
        parent::__construct($RSSItem);
    }

    public function initialMessageContent(): void
    {
        $this->MessageContent = $this->RSSItem->AuthorName . ' 有一則新貼文';
    }

    public function initialColor(): void
    {
        $this->Color = self::TWITTER_COLOR;
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
        $this->TitleLeftImage = self::TWITTER_ICON;
    }

    public function initialTitle(): void
    {
        $this->Title = 'Twitter';
    }

    public function initialTitleUrl(): void
    {
        $this->TitleUrl = $this->RSSItem->PostUrl;
    }

    public function initialTitleRightImage(): void
    {
        $this->TitleRightImage = $this->RSSItem->AuthorIconUrl;
    }

    public function initialDescription(): void
    {
        $this->Description = $this->RSSItem->Content;
    }

    public function initialFooter(): void
    {
        $this->Footer = $this->RSSItem->PostTime->toDateTimeString();
    }

    public function exportSlackMessage(): SlackMessage
    {
        return (new SlackMessage)
            ->content(
                $this->MessageContent
            )
            ->attachment(
                function ($attachment) {
                    $attachment->color($this->Color)
                        ->title(
                            'Twitter',
                            $this->TitleUrl
                        )->author(
                            $this->AuthorName,
                            $this->AuthorMainPageUrl,
                            $this->TitleLeftImage
                        )
                        ->content(
                            $this->Description
                        )
                        ->thumb($this->TitleRightImage)
                        ->footer($this->Footer);
                }
            );
    }
}
