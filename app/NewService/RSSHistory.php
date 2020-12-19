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
        $LatestRSSTime = Carbon::createFromTimestamp(0);
        $RSSCollection->each(
            function ($rss) use (&$LatestRSSTime, &$LatestRSS) {
                if ($rss->PostTime->greaterThan($LatestRSSTime)) {
                    $LatestRSSTime = $rss->PostTime;
                    $LatestRSS = $rss;
                }
            }
        );
        return $LatestRSS;
    }

    public function update(string $subscribe_name, Carbon $current_post_time)
    {
        return $this->RSSHistoryRepo->updateCurrentTime($subscribe_name, $current_post_time);
    }

    public function getLatest(string $subscribe_name)
    {
        $LastPost = $this->RSSHistoryRepo->getLatestPost($subscribe_name);
        if (is_null($LastPost)) {
            $LastPost = $this->RSSHistoryRepo->create($subscribe_name);
        }
        return $LastPost;
    }
}
