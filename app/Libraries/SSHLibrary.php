<?php

namespace App\Libraries;

use Log;
use SSH;
use App\DeployOutputs;

class SSHLibrary
{
    public static function runDeploy($deploy, $deploy_commands){

        SSH::into($deploy->server)->run($deploy_commands, function($line) use ($deploy) {
            $deployOutput = new DeployOutputs();
            $deployOutput->output = $line;
            $deployOutput->created_at = date('Y-m-d G:i:s');
            $deploy->outputs()->save($deployOutput);
            Log::info($line.PHP_EOL);
        });

    }
}
