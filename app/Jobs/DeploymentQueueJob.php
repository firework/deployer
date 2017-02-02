<?php

namespace App\Jobs;

use Log;
use App\Events\DeployOutputsEvent;
use App\Jobs\Job;
use Carbon\Carbon;
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

        $url = route('deploy.status', $deploy->id);

        foreach($deploy->server->integrations as $integration) {
            SlackLibrary::fire($integration->toArray(), null, [ [
                'color' => '#0099d7',
                'text' => "<{$url}|See status here>",
                'title' => 'New build started! :rocket:',
                'footer' => "<!date^{$deploy->created_at->timestamp}^{date_num} - {time}|{$deploy->created_at}>",
                'fields' => [
                    [
                        'title' => 'User',
                        'value' => $deploy->user->name,
                        'short' => true
                    ], [
                        'title' => 'Task',
                        'value' => $deploy->task->name,
                        'short' => true
                    ], [
                        'title' => 'Server',
                        'value' => $deploy->server->name,
                        'short' => true
                    ], [
                        'title' => 'Branch',
                        'value' => $deploy->branch,
                        'short' => true
                    ]
                ],
                'mrkdwn_in' => [ 'text' ]
            ] ]);
        }

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
            $deployOutput->output = mb_convert_encoding($line.PHP_EOL, 'UTF-8');
            $deploy->outputs()->save($deployOutput);

            event(new DeployOutputsEvent($deployOutput));

            Log::info($line.PHP_EOL);
        });

        $deploy->status = 'success';
        $deploy->finished_at = Carbon::now();
        $deploy->save();

        foreach($deploy->server->integrations as $integration) {
            SlackLibrary::fire($integration->toArray(), null, [ [
                'color' => 'good',
                'text' => "<{$url}|See status here>",
                'title' => 'Woohoo! Build success :white_check_mark:',
                'footer' => "<!date^{$deploy->finished_at->timestamp}^{date_num} - {time}|{$deploy->finished_at}>",
                'fields' => [
                    [
                        'title' => 'User',
                        'value' => $deploy->user->name,
                        'short' => true
                    ], [
                        'title' => 'Task',
                        'value' => $deploy->task->name,
                        'short' => true
                    ], [
                        'title' => 'Server',
                        'value' => $deploy->server->name,
                        'short' => true
                    ], [
                        'title' => 'Branch',
                        'value' => $deploy->branch,
                        'short' => true
                    ]
                ],
                'mrkdwn_in' => [ 'text' ]
            ] ]);
        }

        event(new DeployOutputsEvent($deploy->outputs->first()));
    }

    public function failed()
    {
        $deploy = $this->deploy;

        $deploy->status = "error";
        $deploy->finished_at = Carbon::now();
        $deploy->save();

        $url = route('deploy.status', $deploy->id);

        foreach($deploy->server->integrations as $integration) {
            SlackLibrary::fire($integration->toArray(), null, [ [
                'color' => 'danger',
                'text' => "<{$url}|See status here>",
                'title' => 'Help! Build failed :x:',
                'footer' => "<!date^{$deploy->updated_at->timestamp}^{date_num} - {time}|{$deploy->updated_at}>",
                'fields' => [
                    [
                        'title' => 'User',
                        'value' => $deploy->user->name,
                        'short' => true
                    ], [
                        'title' => 'Task',
                        'value' => $deploy->task->name,
                        'short' => true
                    ], [
                        'title' => 'Server',
                        'value' => $deploy->server->name,
                        'short' => true
                    ], [
                        'title' => 'Branch',
                        'value' => $deploy->branch,
                        'short' => true
                    ]
                ],
                'mrkdwn_in' => [ 'text' ]
            ] ]);
        }
    }
}
