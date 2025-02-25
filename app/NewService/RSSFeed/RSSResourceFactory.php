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

        foreach (
            $this->getRSSSimpleXMLElementObjectItem(
                $RSSSimpleXMLElementObject,
                $subscribe->Type
            ) as $ItemKey => $RSSSource
        ) {
            $RSSResource = $this->createRSSResource($subscribe, $RSSSimpleXMLElementObject, $RSSSource);
            $RSSResourceCollection->push($RSSResource);
        }
        return $RSSResourceCollection;
    }

    public function getRSSSimpleXMLElementObjectItem($RSSSimpleXMLElementObject, string $subscribe_name)
    {
        switch ($subscribe_name) {
            case 'Twitter':
                $RSSSimpleXMLElementObjectItem = $RSSSimpleXMLElementObject->channel->item;
                break;
            case 'Github':
            case 'YouTube':
                $RSSSimpleXMLElementObjectItem = $RSSSimpleXMLElementObject->entry;
                break;
        }
        return $RSSSimpleXMLElementObjectItem;
    }

    private function getRSSSimpleXMLElement(string $feed_url): object
    {
        $response = Http::get($feed_url);
        return json_decode(json_encode(simplexml_load_string($response->body())));
    }

    private function createRSSResource(Subscribe $subscribe, object $RSSSimpleXMLElementObject, object $RSSSource): RSS
    {
        switch ($subscribe->Type) {
            case 'Twitter':
                $RSSResource = new Twitter($subscribe, $RSSSimpleXMLElementObject, $RSSSource);
                break;
            case 'Github':
                $RSSResource = new Github($subscribe, $RSSSimpleXMLElementObject, $RSSSource);
                break;
            case 'YouTube':
                $RSSResource = new YouTube($subscribe, $RSSSimpleXMLElementObject, $RSSSource);
                break;
            default:
                dd('RSSResourceFactory createRSSResource cant match subscribe type');
        }
        return $RSSResource;
    }
}
