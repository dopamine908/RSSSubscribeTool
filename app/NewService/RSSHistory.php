<?php


namespace App\NewService;


use App\NewService\RSSFeed\RSS;
use App\Repository\RSSHistory as RSSHistoryRepo;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class RSSHistory
{
    public function __construct(RSSHistoryRepo $RSS_history)
    {
        $this->RSSHistoryRepo = $RSS_history;
    }

    public function filterLatestRSS(Collection $RSSCollection): RSS
    {
//        dump($RSSCollection);
//        dump($RSSCollection->pluck('PostTime'));
//
//        $RSSCollection=collect([
//            $RSSCollection[1],
//            $RSSCollection[3],
//            $RSSCollection[0],
//            $RSSCollection[2],
//                               ]);

        $LatestRSSTime = Carbon::createFromTimestamp(0);
//        dump($LatestRSSTime);
        $RSSCollection->each(
            function ($rss) use (&$LatestRSSTime, &$LatestRSS) {
                if ($rss->PostTime->greaterThan($LatestRSSTime)) {
                    $LatestRSSTime = $rss->PostTime;
                    $LatestRSS = $rss;
                }
            }
        );
//        dump($LatestRSSTime);
//        dump($LatestRSS);
        return $LatestRSS;
    }

    public function update(string $subscribe_name,Carbon $current_post_time)
    {
        dump($subscribe_name,$current_post_time);
        return $this->RSSHistoryRepo->updateCurrentTime($subscribe_name,$current_post_time);
    }

    public function getLatest(string $subscribe_name)
    {
//        dump(123);
        $LastPost = $this->RSSHistoryRepo->getLatestPost($subscribe_name);
        if (is_null($LastPost)) {
            $LastPost = $this->RSSHistoryRepo->create($subscribe_name);
        }
        return $LastPost;
    }
}
