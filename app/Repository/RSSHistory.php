<?php


namespace App\Repository;


use App\Models\RSSHistory as RSSHistoryModel;
use Carbon\Carbon;

class RSSHistory
{
    private $RSSHistoryModel;

    public function __construct(RSSHistoryModel $RSSHistoryModel)
    {
        $this->RSSHistoryModel = $RSSHistoryModel;
    }

    public function getLatestPost($subscribe_name)
    {
//        dump($subscribe_name);exit();
//        dump($this->RSSHistoryModel->where('SubscribeName', 'like', '%'.$subscribe_name.'%')->first());
//        exit();

//        return $this->RSSHistoryModel->firstOrCreate(
//            [
//                'SubscribeName' => $subscribe_name,
//                'CurrentPostTime' => Carbon::now()->toDateTimeString()
//            ]
//        );
$LastPost=$this->RSSHistoryModel->where('SubscribeName', 'like', '%'.$subscribe_name.'%')->first();
//if(is_null($LastPost)){
//    $LastPost=new RSSHistoryModel();
//    $LastPost->SubscribeName= $subscribe_name;
//    $LastPost->CurrentPostTime= Carbon::now()->toDateTimeString();
//    $LastPost->save();
//
//}
        return $LastPost;

//        return $this->RSSHistoryModel->where('SubscribeName', 'like', '%'.$subscribe_name.'%')->firstOrCreate(
//            [
//                'SubscribeName' => $subscribe_name,
//                'CurrentPostTime' => Carbon::now()->toDateTimeString()
//            ]
//        );
    }

    public function updateCurrentTime(string $subscribe_name, Carbon $LastCurrentTime)
    {
        $LastPost=$this->RSSHistoryModel->where('SubscribeName', 'like', '%'.$subscribe_name.'%')->first();
        $LastPost->CurrentPostTime=$LastCurrentTime->toDateTimeString();
        return $LastPost->save();
    }

    public function create(string $subscribe_name){
        $LastPost=new RSSHistoryModel();
        $LastPost->SubscribeName= $subscribe_name;
        $LastPost->CurrentPostTime= Carbon::now()->toDateTimeString();
        $LastPost->save();
        return $LastPost;
    }
}
