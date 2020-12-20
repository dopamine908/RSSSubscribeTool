<?php


namespace App\NewService\Message\Slack;


use App\NewService\Message\MessageTemplate;
use Illuminate\Notifications\Messages\SlackMessage;

class Github extends MessageTemplate implements IExportSlackMessage
{
    const GITHUB_COLOR = '#000000';
    const GITHUB_ICON = 'https://i.imgur.com/J6LeoUb.png';

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
                            $this->Title,
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
