<?php

namespace App\Jobs;

use App\NewService\Dispatcher\Dispatcher;
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
//        dump($this->subscribe);
        $Subscribe = new Subscribe($this->subscribe);
//        dump($Subscribe);
        $RSSResourceFactory = new RSSResourceFactory();
        $RSSCollection=$RSSResourceFactory->createRSSResourceCollection($Subscribe);
//        dump('$RSSCollection');
//        dump($RSSCollection);
        $Filter=new RSSCollectionFilter();
        $BroadcastTarget=$Filter->getNotBroadcastYet($RSSCollection);
//        dump($BroadcastTarget);
        $Dispatcher=new Dispatcher();
        $Dispatcher->broadcastAll($BroadcastTarget);

        if($BroadcastTarget->isNotEmpty()){
            //get latest post and update
            $RSSHistory=app(RSSHistory::class);
            $LatestRSS=$RSSHistory->filterLatestRSS($BroadcastTarget);
//            dump($LatestRSS);
            dump($RSSHistory->update($Subscribe->Name, $LatestRSS->PostTime));
        }
    }
}
