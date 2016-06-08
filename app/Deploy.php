<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deploy extends Model
{
    protected $table = 'deploys';

    protected $fillable = [
        'server_id', 'branch', 'status'
    ];

    public function outputs()
    {
        return $this->hasMany(DeployOutputs::class);
    }

    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    public function serverWithTrashed()
    {
        return $this->server()->withTrashed();
    }
}
