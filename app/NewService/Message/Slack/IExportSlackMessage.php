<?php


namespace App\NewService\Message\Slack;


use Illuminate\Notifications\Messages\SlackMessage;

interface IExportSlackMessage
{
    public function exportSlackMessage(): SlackMessage;
}
