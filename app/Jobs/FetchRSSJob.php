<?php

namespace App\Jobs;

use App\NewService\Dispatcher;
use App\NewService\RSSCollectionFilter;
use App\NewService\RSSFeed\RSSResourceFactory;
use App\NewService\RSSHistory;
use App\NewService\Subscribe;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class FetchRSSJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $subscribe;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $subscribe)
    {
        $this->subscribe = $subscribe;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $Subscribe = new Subscribe($this->subscribe);
//        dump($Subscribe);
//        exit();

        $RSSResourceFactory = new RSSResourceFactory();
        $RSSCollection = $RSSResourceFactory->createRSSResourceCollection($Subscribe);
//        dump($RSSCollection);
//        exit();

        $Filter = new RSSCollectionFilter();
        $BroadcastTarget = $Filter->getNotBroadcastYet($RSSCollection);
        dump($BroadcastTarget->count() . ' jobs to dispatch');
//        dump($BroadcastTarget);
//        exit();

        $Dispatcher = new Dispatcher();
        $Dispatcher->broadcastAll($BroadcastTarget);
//        exit();

        if ($BroadcastTarget->isNotEmpty()) {
            //get latest post and update

            /** @var RSSHistory $RSSHistory */
            $RSSHistory = app(RSSHistory::class);
            $LatestRSS = $RSSHistory->filterLatestRSS($BroadcastTarget);
//            dump($LatestRSS);
            $update_latest_rss_history = $RSSHistory->update($Subscribe->Name, $LatestRSS->PostTime);
            dump($update_latest_rss_history);
        }
    }
}
