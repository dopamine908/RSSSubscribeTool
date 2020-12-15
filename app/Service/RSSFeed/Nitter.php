<?php


namespace App\Service\RSSFeed;


use Illuminate\Support\Arr;
use SimplePie_Item;

class Nitter extends RSSItem
{
    public $author;
    public $post_time;
    public $content;
    public $link;

    public function __construct(SimplePie_Item $simple_pie)
    {
        parent::__construct($simple_pie);
    }

    protected function initialAuthor()
    {
        $original_data = Arr::get(
            $this->child_data,
            'http://purl.org/dc/elements/1.1/',
            'Unknown Original Data'
        );
        $creator_data = Arr::get($original_data, 'creator', 'Unknown Creator');
        $this->author = Arr::get($creator_data, '0.data', 'Unknown Author');;
    }

    protected function initialPostTime()
    {
        $original_data = Arr::get($this->child_data, '', 'empty key value not found');
        $pubDate = Arr::get($original_data, 'pubDate', 'Not Found pubData');
        // TODO carbon 時間轉換
        $this->post_time = Arr::get($pubDate, '0.data', 'Not Found Date Time String');
    }

    protected function initialContent()
    {
//        $original_data = Arr::get($this->child_data, '', 'empty key value not found');
//        $description = Arr::get($original_data, 'description', 'Not found description');
//        $this->content = Arr::get($description, '0.data', 'not found url');

        $original_data = Arr::get($this->child_data, '', 'empty key value not found');
        $title=Arr::get($original_data,'title','title not found');
        $this->content=Arr::get($title,'0.data','title not found');
    }

    protected function initialLink()
    {
        $original_data = Arr::get($this->child_data, '', 'empty key value not found');
        $link = Arr::get($original_data, 'link', 'Not found link');
        $this->link = Arr::get($link, '0.data', 'Not found link');
    }

    protected function initialTitle()
    {
        $original_data = Arr::get($this->child_data, '', 'empty key value not found');
        $title=Arr::get($original_data,'title','title not found');
        $this->title=Arr::get($title,'0.data','title not found');
    }
}
