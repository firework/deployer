<?php

namespace App\Libraries;

use SSH;
use Config;
use App\Models\Server;

class SSHLibrary
{
    private static $server;

    public static function server(Server $server)
    {
        static::$server = $server;

        Config::set('remote.connections.'.$server->id, [
            'host' => $server->host,
            'username' => $server->username,
            'password' => $server->password,
            'key' => $server->key,
            'keytext' => $server->keytext,
            'keyphrase' => $server->keyphrase,
            'agent' => $server->agent,
            'timeout' => $server->timeout,
            'path' => $server->path
        ]);
    }

    public static function run(Server $server, array $deploy_commands, callable $callback = null)
    {
        static::server($server);

        $path = static::$server->path;

        array_unshift($deploy_commands, 'cd '. $path);

        $ssh = SSH::into((string) static::$server->id);

        $ssh->run($deploy_commands, $callback);

        return $ssh;
    }
}
