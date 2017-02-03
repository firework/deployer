<?php

namespace App\Libraries;

use App\Libraries\SSHLibrary;

use App\Models\Server;

class GitLibrary
{
    public static function branches(Server $server)
    {
        $branches = [];
        $commands = ['git branch -r | grep origin | grep -v HEAD | awk -F/ \'{print $2}\''];

        SSHLibrary::run($server, ['git fetch origin -p']);

        SSHLibrary::run($server, $commands, function($line, $a) use (&$branches) {
            $branches = array_filter(explode(PHP_EOL, $line));
        });

        return $branches;
    }
}
