<?php


namespace App\NewService;


use Carbon\Carbon;
use Illuminate\Support\Collection;

class RSSCollectionFilter
{
    public function getNotBroadcastYet(Collection $RSSCollection): Collection
    {
        $CurrentPostTime = $this->getRSSCurrentPostTime($RSSCollection);
        return $RSSCollection->filter(
            function ($RSS) use ($CurrentPostTime) {
                return $RSS->PostTime->greaterThan($CurrentPostTime);
            }
        );
    }

    private function getRSSCurrentPostTime(Collection $RSSCollection): Carbon
    {
        $RSSHistory = app(RSSHistory::class);
        $CurrentPost = $RSSHistory->getLatest($RSSCollection->first()->getSubscribeName());
        return new Carbon($CurrentPost->CurrentPostTime);
    }
}
