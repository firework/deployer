<?php

namespace App\Libraries;

use Cache;
use App\Libraries\SSHLibrary;

class GitLibrary
{
    public static function branches()
    {
        if(!Cache::has('branches')){

            SSHLibrary::run(['git fetch origin -p']);

            $commands = ['git branch -r | grep origin | grep -v HEAD | awk -F/ \'{print $2}\''];

            SSHLibrary::run($commands, function($line, $a) {
                $branches = array_filter(explode(PHP_EOL, $line));

                Cache::put('branches', $branches, 1);
            });
        }

        return Cache::get('branches');
    }
}
