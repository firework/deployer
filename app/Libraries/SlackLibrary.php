<?php
namespace App\Libraries;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class SlackLibrary
{
    public static function fire(array $params, $message = null, $attachments = null)
    {
        $data = [];
        if (array_get($params, 'icon')) {
            $data['icon_emoji'] = array_get($params, 'icon');
        }
        if (array_get($params, 'channel')) {
            $data['channel'] = "#" . array_get($params, 'channel');
        }
        if (array_get($params, 'botname')) {
            $data['username'] = array_get($params, 'botname');
        }
        if ($message) {
            $data['text'] = $message;
        }
        if ($attachments) {
            $data['attachments'] = $attachments;
        }

        $client = new Client();
        $result = $client->post(array_get($params, 'webhook'), [
            'json' => $data
        ]);
    }
}
