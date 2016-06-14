<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deploy extends Model
{
    protected $table = 'deploys';

    protected $dates = ['finished_at'];

    protected $fillable = [
        'user_id', 'server_id', 'branch', 'status', 'finished_at'
    ];

    public function outputs()
    {
        return $this->hasMany(DeployOutputs::class);
    }

    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function serverWithTrashed()
    {
        return $this->server()->withTrashed();
    }


    public function getAllOutputsAttribute()
    {
        $allOutputs = null;

        foreach ($this->outputs as $output) {
            $allOutputs .= nl2br($output->output);
        }

        return $allOutputs;
    }

    public function getShortOutputAttribute()
    {
        $outputs = $this->outputs;
        $shortOutput = '';

        if (! $outputs->isEmpty()) {
            $lines = array_filter(explode(PHP_EOL, $outputs->first()->output));
            $shortOutput = $lines[0];

            if ($outputs->count() > 1) {
                $lines = array_filter(explode(PHP_EOL, $outputs->last()->output));
                $shortOutput .= PHP_EOL . '...' . PHP_EOL . end($lines) . PHP_EOL;
            }else{
                if(count($lines) > 1){
                    $shortOutput .= PHP_EOL . '...' . PHP_EOL . end($lines) . PHP_EOL;
                }
            }
        }

        return nl2br($shortOutput);
    }
}
