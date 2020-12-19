<?php


namespace App\NewService\RSSFeed;


use App\NewService\Subscribe;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class RSSResourceFactory
{
    public function createRSSResourceCollection(Subscribe $subscribe): Collection
    {
        $RSSResourceCollection = new Collection();
        $RSSSimpleXMLElementObject = $this->getRSSSimpleXMLElement($subscribe->FeedUrl);
//        dump($RSSSimpleXMLElementObject);
//        exit();

        // TODO 拿資料的方式不一樣
//        foreach ($RSSSimpleXMLElementObject->channel->item as $ItemKey => $RSSSource) {
        foreach ($RSSSimpleXMLElementObject->entry as $ItemKey => $RSSSource) {
            $RSSResource = $this->createRSSResource($subscribe, $RSSSimpleXMLElementObject, $RSSSource);
//            dump($RSSResource);
            $RSSResourceCollection->push($RSSResource);
//            exit();
        }
        return $RSSResourceCollection;
    }

    private function getRSSSimpleXMLElement(string $feed_url): object
    {
        $response = Http::get($feed_url);
        return json_decode(json_encode(simplexml_load_string($response->body())));
    }

    private function createRSSResource(Subscribe $subscribe, object $RSSSimpleXMLElementObject, object $RSSSource): RSS
    {
//        dump($subscribe->Type);
//        exit;
        switch ($subscribe->Type) {
            case 'Twitter':
                $RSSResource = new Twitter($subscribe, $RSSSimpleXMLElementObject, $RSSSource);
                break;
            case 'Github':
                $RSSResource = new Github($subscribe, $RSSSimpleXMLElementObject, $RSSSource);
                break;
//            case 'YouTube':
//                $RSSResource = new YouTube($subscribe, $RSSResource);
//                break;
        }
//        dump($RSSResource);
        return $RSSResource;
    }
}
