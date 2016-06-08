<?php

namespace App\Jobs;

use App\Deploy;
use App\DeployOutputs;
use App\Jobs\Job;
use App\Libraries\SSHLibrary;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use Storage;

class DeploymentQueueJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $deploy;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($deploy)
    {
        $this->deploy = $deploy;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info("Handling queue...");

        $deploy = $this->deploy;
        $deploy_commands = '';

        if(Storage::exists('deploy_command')){
            $deploy_commands = Storage::get('deploy_command');
            $deploy_commands = explode(PHP_EOL, $deploy_commands);

            foreach ($deploy_commands as $key => &$deploy_command) {
                $deploy_command = str_replace(["\r", "\n", "\t"], '', $deploy_command);
                $deploy_command = preg_replace('/({{\s*branch\s*}})/', $deploy->branch, $deploy_command);
                $deploy_command = preg_replace('/({{\s*server\s*}})/', $deploy->server->name, $deploy_command);
            }

            SSHLibrary::server($deploy->server);

            SSHLibrary::run($deploy_commands, function($line) use ($deploy) {
                $deployOutput = new DeployOutputs();
                $deployOutput->output = $line.PHP_EOL;
                $deployOutput->created_at = date('Y-m-d G:i:s');
                $deploy->outputs()->save($deployOutput);
                Log::info($line.PHP_EOL);
            });

            $deploy->status = "success";
            $deploy->save();

        } else {

            $deployOutput = new DeployOutputs();
            $deployOutput->created_at = date('Y-m-d G:i:s');
            $deployOutput->output = "No command lines found.";

            $deploy->outputs()->save($deployOutput);
            $deploy->status = 'error';
            $deploy->save();

        }

    }

    public function failed()
    {
        $this->deploy->status = "error";
        $this->deploy->save();
    }
}
