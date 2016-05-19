<?php

namespace App\Jobs;

use App\Deploy;
use App\DeployOutputs;
use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use SSH;
use Log;
use File;

class DeploymentQueueJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $deploy_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($deploy_id)
    {
        $this->deploy_id = $deploy_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info("Handling queue...");

        $deploy = Deploy::find($this->deploy_id);

        $deploy_commands = File::get( base_path() . '/deploy_command' );
        $deploy_commands = explode(PHP_EOL, $deploy_commands);

        $deploy_commandsX = [];
        foreach ($deploy_commands as $key => &$deploy_command) {
            $deploy_command = str_replace(["\r", "\n", "\t"], '', $deploy_command);
            $deploy_command = preg_replace('/({{\s*branch\s*}})/', $deploy->branch, $deploy_command);
            $deploy_command = preg_replace('/({{\s*server\s*}})/', $deploy->server, $deploy_command);
        }

        // ToDo: The right way to send a sequence of commands that should be run together it the way below, but it's not working - Needs investigation!
        // SSH::into($deploy->server)->define('deploy', $deploy_commands);
        // SSH::into($deploy->server)->task('deploy', function($line) {
        //     Log::info($line.PHP_EOL);
        // });

        SSH::into($deploy->server)->run($deploy_commands, function($line) use ($deploy) {
            $deployOutput = new DeployOutputs();
            $deployOutput->output = $line;
            $deployOutput->created_at = date('Y-m-d G:i:s');
            $deploy->outputs()->save($deployOutput);
            Log::info($line.PHP_EOL);
        });

        $deploy->status = "sucess";
        $deploy->save();
    }

    private function failed()
    {
        $deploy = Deploy::find($this->deploy_id);
        $deploy->status = "error";
        $deploy->save();
    }
}
