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
//        dump($RSSSimpleXMLElementObject);exit();

        foreach ($RSSSimpleXMLElementObject->channel->item as $ItemKey => $RSSSource) {
//            $j = json_encode($RSSSource);
//            $o = json_decode($j);
//            dump($o);
//            dump($ItemKey);
//            dump($RSSSource);
//            dump($RSSSource->link);
//            dump($RSSSource->description);
//            dump((string)$RSSSource->content);
//            dump('------');
            $RSSResource = $this->createRSSResource($subscribe, $RSSSimpleXMLElementObject,$RSSSource);
            $RSSResourceCollection->push($RSSResource);
//            dump('result');
//            dump($RSSResource);
//            exit();
        }
//        exit();
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
        switch ($subscribe->Type) {
            case 'Twitter':
                $RSSResource = new Twitter($subscribe, $RSSSimpleXMLElementObject, $RSSSource);
                break;
//            case 'Github':
//                $RSSResource = new Github($subscribe, $RSSResource);
//                break;
//            case 'YouTube':
//                $RSSResource = new YouTube($subscribe, $RSSResource);
//                break;
        }
        return $RSSResource;
    }
}
