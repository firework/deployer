<?php

namespace App\Jobs;

use App\Events\DeployOutputsEvent;
use App\Jobs\Job;
use Carbon\Carbon;
use App\Models\Deploy;
use App\Models\DeployOutputs;
use App\Libraries\SSHLibrary;
use App\Libraries\SlackLibrary;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;


class DeploymentQueueJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $deploy;
    protected $startedAt;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Deploy $deploy)
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
        $this->startedAt = Carbon::now();

        $deploy = $this->deploy;
        $deploy->status = Deploy::STATUS_RUNNING;
        $deploy->save();

        $url = route('deploy.status', $deploy->id);

        foreach($deploy->server->integrations as $integration) {
            SlackLibrary::fire($integration->toArray(), null, [ [
                'color' => '#0099d7',
                'title' => 'New build started! :rocket:',
                'title_link' => $url,
                'fields' => $this->getSlackAttachmentFields(),
            ] ]);
        }

        $deploy_commands = explode(PHP_EOL, $deploy->task->commands);

        foreach ($deploy_commands as $key => &$deploy_command) {
            $deploy_command = str_replace(["\r", "\n", "\t"], '', $deploy_command);
            $deploy_command = preg_replace('/({{\s*branch\s*}})/', $deploy->branch, $deploy_command);
            $deploy_command = preg_replace('/({{\s*server\s*}})/', $deploy->server->name, $deploy_command);
        }

        $deploy_commands = array_filter($deploy_commands);

        $ssh = SSHLibrary::run($deploy->server, $deploy_commands, function($line) use ($deploy) {
            $deployOutput = new DeployOutputs();
            $deployOutput->output = mb_convert_encoding($line.PHP_EOL, 'UTF-8');
            $deploy->outputs()->save($deployOutput);

            event(new DeployOutputsEvent($deployOutput));
        });

        if ($ssh->status() !== 0) {
            $this->failed();

            return;
        }

        $deploy->status = Deploy::STATUS_SUCCESS;
        $deploy->finished_at = Carbon::now();
        $deploy->save();

        $timeTaken = $deploy->finished_at->diffInSeconds($this->startedAt);

        foreach($deploy->server->integrations as $integration) {
            SlackLibrary::fire($integration->toArray(), null, [ [
                'color' => 'good',
                'title' => "Build success! :white_check_mark: Took {$timeTaken} seconds.",
                'title_link' => $url,
                'fields' => $this->getSlackAttachmentFields(),
            ] ]);
        }

        event(new DeployOutputsEvent($deploy->outputs->first()));
    }

    public function failed()
    {
        $deploy = $this->deploy;

        $deploy->status = Deploy::STATUS_ERROR;
        $deploy->finished_at = Carbon::now();
        $deploy->save();

        $timeTaken = $deploy->finished_at->diffInSeconds($this->startedAt);

        $url = route('deploy.status', $deploy->id);

        foreach($deploy->server->integrations as $integration) {
            SlackLibrary::fire($integration->toArray(), null, [ [
                'color' => 'danger',
                'title' => "Build failed! :x: Took {$timeTaken} seconds.",
                'title_link' => $url,
                'fields' => $this->getSlackAttachmentFields(),
            ] ]);
        }

        event(new DeployOutputsEvent($deploy->outputs->first()));
    }

    public function getSlackAttachmentFields()
    {
        return [
            [
                'title' => 'User',
                'value' => $this->deploy->user->name,
                'short' => true,
            ], [
                'title' => 'Task',
                'value' => $this->deploy->task->name,
                'short' => true,
            ], [
                'title' => 'Server',
                'value' => $this->deploy->server->name,
                'short' => true,
            ], [
                'title' => 'Branch',
                'value' => $this->deploy->branch,
                'short' => true,
            ],
        ];
    }
}
