<?php


namespace App\Service\RSSFeed;


use Illuminate\Support\Arr;
use SimplePie_Item;

abstract class RSSItem
{
    protected $child_data;
    public $author;
    public $post_time;
    public $content;
    public $link;
    public $title;

    public function __construct(SimplePie_Item $simple_pie)
    {
//        dump('in construct');
//    dump($simple_pie);
//        $child_data = Arr::get($simple_pie->data, 'child', 'child not found');
//        dump($child_data);
        $this->getChildData($simple_pie);
$this->initialTitle();
        $this->initialAuthor();
        $this->initialPostTime();
        $this->initialLink();
        $this->initialContent();
//        dump('in construct');
    }

    protected function getChildData($simple_pie)
    {
        $this->child_data = Arr::get($simple_pie->data, 'child', 'child not found');
    }

    abstract protected function initialAuthor();

    abstract protected function initialPostTime();

    abstract protected function initialContent();

    abstract protected function initialLink();
    abstract protected function initialTitle();
}
