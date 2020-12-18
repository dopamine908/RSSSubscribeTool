<?php


namespace App\Service\RSSFeed;


use Carbon\Carbon;
use SimplePie_Item;

class Github extends RSSItem
{

    /**
     * Github constructor.
     */
    public function __construct(SimplePie_Item $simple_pie,$observer)
    {
//        dump($simple_pie);
        $this->source='Github';
        $this->observer = $observer;

        parent::__construct($simple_pie);
    }

    protected function initialAuthorAccount()
    {
//dump($this->child_data['http://www.w3.org/2005/Atom']['author'][0]['child']['http://www.w3.org/2005/Atom']['name'][0]['data']);
        $this->author_account = $this->child_data['http://www.w3.org/2005/Atom']['author'][0]['child']['http://www.w3.org/2005/Atom']['name'][0]['data'];
    }

    protected function initialAuthorShowName()
    {
//        $this->author_show_name = $this->child_data['http://www.w3.org/2005/Atom']['author'][0]['child']['http://www.w3.org/2005/Atom']['name'][0]['data'];

        $original_link=$this->simple_pie_data->data['child']['http://www.w3.org/2005/Atom']['feed'][0]['child']['http://www.w3.org/2005/Atom']['link'][0]['attribs']['']['href'];
//        dump(explode('/',$original_link)[3]);
        $this->author_show_name= explode('/',$original_link)[3].'/'.explode('/',$original_link)[4];
    }

    protected function initialAuthorImageLink()
    {
        $this->author_image_link = $this->child_data['http://search.yahoo.com/mrss/']['thumbnail'][0]['attribs']['']['url'];
//        dump($this->child_data['http://search.yahoo.com/mrss/']['thumbnail'][0]['attribs']['']['url']);
    }

    protected function initialAuthorMainPageLink()
    {
        $original_link= $this->simple_pie_data->data['child']['http://www.w3.org/2005/Atom']['feed'][0]['child']['http://www.w3.org/2005/Atom']['link'][0]['attribs']['']['href'];
//        dump(explode('releases',$original_link));
        $this->author_main_page_link=explode('releases',$original_link)[0];

    }

    protected function initialLink()
    {
        $this->link = $this->simple_pie_data->data['child']['http://www.w3.org/2005/Atom']['feed'][0]['child']['http://www.w3.org/2005/Atom']['link'][0]['attribs']['']['href'];
//        dump($this->simple_pie_data->data['child']['http://www.w3.org/2005/Atom']['feed'][0]['child']['http://www.w3.org/2005/Atom']['link'][0]['attribs']['']['href']);
    }

    protected function initialContent()
    {
        $this->content = $this->child_data['http://www.w3.org/2005/Atom'] ['title'][0]['data'];
    }

    protected function initialPostTime()
    {
        $this->post_time = $this->child_data['http://www.w3.org/2005/Atom'] ['updated'][0]['data'];
//        dump(new Carbon($this->post_time));
        $this->post_time=new Carbon($this->post_time);

    }
}
