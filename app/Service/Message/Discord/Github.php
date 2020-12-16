<?php


namespace App\Service\Message\Discord;


use App\Service\Message\MessageTemplate;
use App\Service\RSSFeed\RSSItem;

class Github extends MessageTemplate
{

    function getTemplateContent($RSS_item)
    {
        return  [
            'content' => $RSS_item->author_show_name . ' new release -> version : '.$RSS_item->content,
            'embeds' => [
                [
//                    'title' => 'Twitter',
                    'title' => 'Github - '.$RSS_item->author_show_name . ' new release -> version : '.$RSS_item->content,
//                    'url' => 'https://gist.github.com/Birdie0/78ee79402a4301b1faf412ab5f1cdcf9',
                    'url' => $RSS_item->link,
                    'description' => 'release version : '.$RSS_item->content,
                    'color' => hexdec('#000000'),
                    'footer' => [
                        'text' => $RSS_item->post_time,
                    ],
                    "author" => [
                        "name" => $RSS_item->author_show_name,
                        "url" => $RSS_item->author_main_page_link,
//                        "icon_url" => $RSS_item->author_image_link
                    ],
                ],
            ],
        ];

    }
}
