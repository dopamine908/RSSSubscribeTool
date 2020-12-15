<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Vedmant\FeedReader\Facades\FeedReader;
use Illuminate\Support\Arr;
Route::get('/', function () {
//    FeedReader::read('https://github.com/laravel/framework/releases.atom');
//    dump(FeedReader::read('https://github.com/laravel/framework/releases.atom'));
    dump(FeedReader::read('https://nitter.net/Dopamin908/rss')->get_items());
//    dump(FeedReader::read('https://nitter.net/Dopamin908/rss'));

    $rss_items=FeedReader::read('https://nitter.net/Dopamin908/rss')->get_items();
    foreach ($rss_items as $rss_item){
//        dump($rss_item->data);
//        Arr::get($rss_item->data,'child','child not found');
        $child_data=Arr::get($rss_item->data,'child','child not found');
//        dump($child_data);

        dump(Arr::get($child_data,'', 'empty key value not found'));
    }
});
