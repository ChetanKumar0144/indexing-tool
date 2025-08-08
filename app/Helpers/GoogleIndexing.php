<?php

namespace App\Helpers;

use Google\Client;
use Google\Service\Indexing;
use Google\Service\Indexing\UrlNotification;

class GoogleIndexing
{
    public static function indexUrl($jsonKeyPath, $url)
    {
        $client = new Client();
        $client->setAuthConfig($jsonKeyPath);
        $client->addScope(Indexing::INDEXING);
        $client->setApplicationName('Laravel Indexing Tool');

        $service = new Indexing($client);

        $notification = new UrlNotification();
        $notification->setType('URL_UPDATED');
        $notification->setUrl($url);

        return $service->urlNotifications->publish($notification);
    }
}
