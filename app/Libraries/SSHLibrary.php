<?php

namespace App\Libraries;

use SSH;

class SSHLibrary
{

    private static $server;

    public static function server($server){
        static::$server = $server;
    }

    public static function run(array $deploy_commands, callable $callback = null){

        if(!isset(static::$server)){
            static::$server = config('remote.default');
        }

        $path = config('remote.connections')[static::$server]['path'];

        array_unshift($deploy_commands , 'cd '. $path);

        SSH::into(static::$server)->run($deploy_commands, $callback);
    }
}
