<?php

namespace App\Services;

class GoogleAPIServices
{
    public static function getService()
    {
        // configure the Google Client
        $client = new \Google_Client();
        $client->setApplicationName('Google Sheets API');
        $client->setScopes([\Google\Service\Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');
        // credentials.json is the key file we downloaded while setting up our Google Sheets API
        $client->setAuthConfig(env('GOOGLE_APPLICATION_CREDENTIALS'));

        // configure the Sheets Service
        $service = new \Google\Service\Sheets($client);
        return $service;
    }
}
