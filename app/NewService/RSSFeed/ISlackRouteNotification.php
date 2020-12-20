<?php


namespace App\NewService\RSSFeed;


interface ISlackRouteNotification
{
    public function routeNotificationFor($driver, $notification = null);
}
