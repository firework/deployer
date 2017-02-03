<?php
namespace App\Libraries;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class SlackLibrary
{
    public static function fire(array $params, $message = null, $attachments = null)
    {
        $data = [];

        if ($icon = array_get($params, 'icon')) {
            $data['icon_emoji'] = $icon;
        }

        if ($channel = array_get($params, 'channel')) {
            $data['channel'] = "#" . $channel;
        }

        if ($botname = array_get($params, 'botname')) {
            $data['username'] = $botname;
        }

        if ($message) {
            $data['text'] = $message;
        }

        if ($attachments) {
            $data['attachments'] = $attachments;
        }

        $result = with(new Client)->post(array_get($params, 'webhook'), [ 'json' => $data ]);
    }
}
