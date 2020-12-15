<?php


namespace App\Service;


use Illuminate\Support\Arr;
use SimplePie_Item;

class RSSItem
{

    public $author;
    public $post_time;
    public $content;
    public $link;

    public function __construct(SimplePie_Item $simple_pie)
    {
//        dump('in construct');
//    dump($simple_pie);
        $child_data = Arr::get($simple_pie->data, 'child', 'child not found');
//        dump($child_data);

        $this->initialAuthor($child_data);
        $this->initialPostTime($child_data);
        $this->initialLink($child_data);
        $this->initialContent($child_data);
//        dump('in construct');
    }

    private function initialAuthor($child_data)
    {
        $original_data = Arr::get(
            $child_data,
            'http://purl.org/dc/elements/1.1/',
            'Unknown Original Data'
        );
        $creator_data = Arr::get($original_data, 'creator', 'Unknown Creator');
        $this->author = Arr::get($creator_data, '0.data', 'Unknown Author');;
    }

    private function initialPostTime($child_data)
    {
        $original_data = Arr::get($child_data, '', 'empty key value not found');
        $pubDate = Arr::get($original_data, 'pubDate', 'Not Found pubData');
        // TODO carbon 時間轉換
        $this->post_time = Arr::get($pubDate, '0.data', 'Not Found Date Time String');
    }

    private function initialContent($child_data)
    {
        $original_data = Arr::get($child_data, '', 'empty key value not found');
        $description = Arr::get($original_data, 'description', 'Not found description');
        $this->content = Arr::get($description, '0.data', 'not found url');
    }

    private function initialLink($child_data)
    {
        $original_data = Arr::get($child_data, '', 'empty key value not found');
        $link = Arr::get($original_data, 'link', 'Not found link');
        $this->link = Arr::get($link, '0.data', 'Not found link');
    }
}
