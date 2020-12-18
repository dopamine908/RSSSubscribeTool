<?php


namespace App\NewService\Message\Discord;


use Awssat\Notifications\Messages\DiscordMessage;

interface IExportDiscordMessage
{
public function exportDiscordMessage():DiscordMessage;
}
