<?php


namespace App\NewService\Dispatcher;


use App\Jobs\NotificationJob;
use App\NewService\RSSFeed\RSS;
use Illuminate\Support\Collection;

class Dispatcher
{

    public function broadcastAll(Collection $RSSCollection)
    {
//        $RSSItem->notify();
        $RSSCollection->each(
            function ($RSS) {
                $this->broadcast($RSS);
//            exit();
            }
        );
    }

    public function broadcast(RSS $RSSItem)
    {
//        dump($RSSItem);
//        $all_wait_to_notify=$RSSItem->Subscribe->observer;
        $Observers = $RSSItem->getObservers();
//        dump($Observers);
//        $all_wait_to_notify->each(function ($item){
//            $RSSItem->notify();
        // Job::dispatch
        //(one message , many target)
//        });
        $Observers->each(
            function ($observer) use ($RSSItem) {
                NotificationJob::dispatch($RSSItem, $observer)->onQueue('Notification');
            }
        );
    }
}
