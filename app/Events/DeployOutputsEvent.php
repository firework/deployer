<?php

namespace App\Events;

use App\Models\DeployOutputs;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class DeployOutputsEvent extends Event implements ShouldBroadcastNow
{
    // use SerializesModels;

    public $deployOutputs;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(DeployOutputs $deployOutputs)
    {
        $this->deployOutputs = $deployOutputs;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['deploy-outputs.'.$this->deployOutputs->deploy->id];
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        $deploy = $this->deployOutputs->deploy;
        $output = $deploy->status != 'success' ? nl2br($this->deployOutputs->output) : '';

        return compact('deploy', 'output');
    }
}
