<?php


namespace App\Service\RSSFeed;


use Illuminate\Support\Arr;
use SimplePie_Item;

class Nitter extends RSSItem
{
//    public $author;
//    public $post_time;
//    public $content;
//    public $link;

    public function __construct(SimplePie_Item $simple_pie)
    {
        $this->source='Twitter';
        parent::__construct($simple_pie);
    }

    protected function initialAuthorAccount()
    {
        $original_data = Arr::get(
            $this->child_data,
            'http://purl.org/dc/elements/1.1/',
            'Unknown Original Data'
        );
        $creator_data = Arr::get($original_data, 'creator', 'Unknown Creator');
        $this->author_account = Arr::get($creator_data, '0.data', 'Unknown Author');;
    }

    protected function initialAuthorShowName()
    {
        $this->author_show_name = $this->simple_pie_data->data['child']['']['rss'][0]['child']['']['channel'][0]['child']['']['title'][0]['data'];
    }

    protected function initialAuthorMainPageLink()
    {
        $this->author_main_page_link = 'https://twitter.com/' . $this->author_account;
    }

    protected function initialAuthorImageLink()
    {
//        dump($this->child_data);
//        dump($this->simple_pie_data);
//        dump(
//            $this->simple_pie_data->data['child']['']['rss'][0]['child']['']['channel'][0]['child']['']['title'][0]['data']
//        );
//        dump(
//            $this->simple_pie_data->data['child']['']['rss'][0]['child']['']['channel'][0]['child']['']['image'][0]['child']['']['url']['0']['data']
//        );
//        exit();
        $this->author_image_link = $this->simple_pie_data->data['child']['']['rss'][0]['child']['']['channel'][0]['child']['']['image'][0]['child']['']['url']['0']['data'];
//        $this->author=$this->simple_pie_data->data['child']['']['rss'][0]['child']['']['channel'][0]['child']['']['title'][0]['data'];
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
        $title = Arr::get($original_data, 'title', 'title not found');
        $this->content = Arr::get($title, '0.data', 'title not found');
    }

    protected function initialLink()
    {
        $original_data = Arr::get($this->child_data, '', 'empty key value not found');
        $link = Arr::get($original_data, 'link', 'Not found link');
        $nitter_link = Arr::get($link, '0.data', 'Not found link');

        $post_uid_with_sharp = Arr::last(explode("/", $nitter_link));
        $post_uid = Arr::first(explode("#", $post_uid_with_sharp));
$this->link='https://twitter.com/'.$this->author_account.'/status/'.$post_uid;
//        dump($post_uid);
    }

//    protected function initialTitle()
//    {
//        $original_data = Arr::get($this->child_data, '', 'empty key value not found');
//        $title=Arr::get($original_data,'title','title not found');
//        $this->title=Arr::get($title,'0.data','title not found');
//    }


}
