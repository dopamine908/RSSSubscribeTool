<?php


return [
    'subscribe' => [
        /*
         * key name is decided by you want
         */
        'key_name_you_want' => [
            /*
             * You can only choose :
             * Twitter
             * Github
             * YouTube
             */
            'type' => 'Twitter', // Twitter,Github,YouTube
            /**
             * rss url
             * twitter : use nitter's feed url (https://nitter.net/)
             *          like this -> https://nitter.net/taylorotwell/rss
             * github : https://github.com/laravel/framework/releases.atom
             * youtube : https://www.youtube.com/feeds/videos.xml?channel_id={channel_id}
             */
            'feed_url' => 'https://nitter.net/taylorotwell/rss',
            /*
             * you can use key name below, add in this array
             */
            'observer' => ['discord_others', 'slack_test'] // notify key
        ],

        // example
        'some_one_twitter' => [
            'type' => 'Twitter', // Twitter,Github,YouTube
            'feed_url' => 'rss feed url',
            'observer' => ['observer_1'] // notify key
        ],
        'some_one_github' => [
            'type' => 'Github', // Twitter,Github,YouTube
            'feed_url' => 'rss feed url',
            'observer' => ['observer_2'] // notify key
        ],
        'some_one_youyube' => [
            'type' => 'YouTube', // Twitter,Github,YouTube
            'feed_url' => 'rss feed url',
            'observer' => ['observer_1', 'observer_2'] // notify key
        ],
    ],
    'observer' => [
        /*
        * key name is decided by you want
        */
        'observer_1' => [
            /**
             * you can only choose :
             * Discord
             * Slack
             */
            'type' => 'Discord', //Discord, Slack
            'web_hook' => 'your web hook url'
        ],
        'observer_2' => [
            /**
             * you can only choose :
             * Discord
             * Slack
             */
            'type' => 'Slack', //Discord, Slack
            'web_hook' => 'your web hook url'
        ],

    ]
];
