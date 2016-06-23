<?php

namespace App\Jobs;

use Log;
use App\Events\DeployOutputsEvent;
use App\Jobs\Job;
use Carbon\Carbon;
use App\Models\DeployOutputs;
use App\Libraries\SSHLibrary;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;


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
        $deploy->status = 'running';
        $deploy->save();

        $deploy_commands = $deploy->task->commands;

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
            $deploy->outputs()->save($deployOutput);

            event(new DeployOutputsEvent($deployOutput));

            Log::info($line.PHP_EOL);
        });

        $deploy->status = 'success';
        $deploy->finished_at = Carbon::now();
        $deploy->save();

        event(new DeployOutputsEvent($deploy->outputs->first()));
    }

    public function failed()
    {
        $this->deploy->status = "error";
        $this->deploy->finished_at = Carbon::now();
        $this->deploy->save();
    }
}
