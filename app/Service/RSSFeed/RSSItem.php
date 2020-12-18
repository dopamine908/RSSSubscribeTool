<?php


namespace App\Service\RSSFeed;


use Illuminate\Support\Arr;
use SimplePie_Item;

abstract class RSSItem
{
    protected $child_data;
    protected $simple_pie_data;

    public $source;

    public $author_account;
    public $author_show_name;
    public $author_image_link;
    public $author_main_page_link;
    public $post_time;
    public $content;
    public $link;

    public $observer;
//    public $title;

    public function __construct(SimplePie_Item $simple_pie)
    {
//        dump('in construct');
//    dump($simple_pie);
//        $child_data = Arr::get($simple_pie->data, 'child', 'child not found');
//        dump($child_data);
        $this->getChildData($simple_pie);
        $this->getSimplePieData($simple_pie);

        $this->initialAuthorAccount();
        $this->initialAuthorShowName();
        $this->initialAuthorImageLink();
        $this->initialAuthorMainPageLink();

        $this->initialLink();
        $this->initialContent();
        $this->initialPostTime();

//$this->initialTitle();

//        dump('in construct');
    }

    private function getChildData($simple_pie)
    {
        $this->child_data = Arr::get($simple_pie->data, 'child', 'child not found');
    }
    private function getSimplePieData($simple_pie){

//        dump($simple_pie);
        $this->simple_pie_data = $simple_pie->feed;

    }

    abstract protected function initialAuthorAccount();
    abstract protected function initialAuthorShowName();
    abstract protected function initialAuthorImageLink();
    abstract protected function initialAuthorMainPageLink();

    abstract protected function initialLink();
    abstract protected function initialContent();
    abstract protected function initialPostTime();


//    abstract protected function initialTitle();
}
