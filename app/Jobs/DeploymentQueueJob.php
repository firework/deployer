<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use SSH;
use Log;

class DeploymentQueueJob extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $server;
    protected $branch;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($server, $branch)
    {
        $this->server = $server;
        $this->branch = $branch;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info("Handling queue...");
        Log::info($this->server);
        Log::info($this->branch);

        $deploy_commands = [
            'cd /vagrant',
            'git checkout ' . $this->branch,
            'git branch',
        ];

        // $deploy_commands = [
        //     'git branch -r',
        //     'git fetch origin -p',
        //     'git checkout origin/' . $this->branch,
        //     'composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader',
        //     'php artisan plint:migrate',
        //     'gulp --production',
        // ];

        // SSH::into($this->server)->define('deploy', $deploy_commands);
        // SSH::into($this->server)->task('deploy', function($line) {
        //     Log::info($line.PHP_EOL);
        // });

        SSH::into($this->server)->run($deploy_commands, function($line) {
            Log::info($line.PHP_EOL);
        });
    }
}
