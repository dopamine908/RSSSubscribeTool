<?php


namespace App\NewService;


use App\Jobs\NotificationJob;
use App\NewService\RSSFeed\RSS;
use Illuminate\Support\Collection;

class Dispatcher
{

    public function broadcastAll(Collection $RSSCollection)
    {
        $RSSCollection->each(
            function ($RSS) {
                $this->broadcast($RSS);
            }
        );
    }

    public function broadcast(RSS $RSSItem)
    {
        $Observers = $RSSItem->getObservers();
        dump('Job::dispatch');
        dump($Observers);

        $Observers->each(
            function ($observer) use ($RSSItem) {
                NotificationJob::dispatch($RSSItem, $observer)->onQueue('Notification');
            }
        );
    }
}
