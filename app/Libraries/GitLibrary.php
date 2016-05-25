<?php

namespace App\Libraries;

use SSH;
use Cache;
use Carbon\Carbon;

class GitLibrary
{
    public static function branches()
    {
        if(!Cache::has('branches')){
            SSH::run([
                'cd /vagrant',
                'git branch',
            ], function($line)
            {
                $branches = explode(PHP_EOL, $line);

                foreach ($branches as $key => $value) {
                    $branches[$key] = str_replace(['*', ' '], "", $value);
                    if (empty($branches[$key])){
                        unset($branches[$key]);
                    }
                }

                $expiresAt = Carbon::now()->addMinutes(1);
                Cache::add('branches', $branches, $expiresAt);
            });
        }

        return Cache::get('branches');
    }
}
