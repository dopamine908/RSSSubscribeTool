<?php


return [
    'subscribe' => [
        [
            'type' => 'Nitter',
            'name' => 'taylorotwell',
            'feed_url' => 'https://nitter.net/taylorotwell/rss',
            'observer' => ['discord', 'slack']
        ],
//        [
//            'type'=>'Nitter',
//            'name'=>'bemanistyle',
//            'feed_url' => 'https://nitter.net/bemanistyle/rss',
//            'observer' => ['discord', 'slack']
//        ],
//        [
//            'type'=>'Nitter',
//            'name'=>'Wzettairyouiki',
//            'feed_url' => 'https://nitter.net/Wzettairyouiki/rss',
//            'observer' => ['discord', 'slack']
//        ]
        [

            'type' => 'Github',
            'name' => 'laravel',
            'feed_url' => 'https://github.com/laravel/framework/releases.atom',
            'observer' => ['discord', 'slack']
        ]
    ],
    'notify' => [
        'discord' => [
            'web_hook' => 'https://discord.com/api/webhooks/787959967205687306/2ZWfiat0i1wJ3GYl3aFKV6csdP4nSx78wcT9auaB1TpA1OmmpUysvPqGbRgbPDQRJS-I'
        ],
        'slack' => [
            'web_hook' => ''
        ]
    ]
];
