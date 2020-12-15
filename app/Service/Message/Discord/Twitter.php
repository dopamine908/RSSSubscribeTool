<?php


namespace App\Service\Message\Discord;


use App\Service\Message\MessageTemplate;

class Twitter extends MessageTemplate
{

    function getTemplateContent($RSS_item)
    {
        return  [
            'content' => $RSS_item->author_show_name . ' 有一則新的貼文',
//            'content' => 'TestAuthor 有一則新的貼文',
            'embeds' => [
                [
                    'title' => 'Twitter',
//                    'title' => 'Github',
//                    'url' => 'https://gist.github.com/Birdie0/78ee79402a4301b1faf412ab5f1cdcf9',
                    'url' => $RSS_item->link,
                    'description' => $RSS_item->content,
                    'color' => hexdec('#1FA1F1'),
                    'footer' => [
                        'text' => $RSS_item->post_time,
                    ],
                    "author" => [
                        "name" => $RSS_item->author_show_name,
                        "url" => $RSS_item->author_main_page_link,
                        "icon_url" => $RSS_item->author_image_link
                    ],
                ],
            ],
        ];

    }
}
