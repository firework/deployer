<?php
namespace App\Libraries;

class SlackLibrary
{
    protected $message;

    function __construct($message)
    {
        $this->message = $message;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function fire()
    {
        $data = json_encode(array(
            'channel'    => '#' . env('SLACK_CHANNEL', 'general'),
            'username'   => env('SLACK_BOTNAME', 'deployer'),
            'text'       => $this->message,
            'icon_emoji' => env('SLACK_ICON', ':rocket:')
        ));

        $ch = curl_init(env('SLACK_WEBHOOK'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
    }
}
