<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SlackIntegration extends Model
{
    use SoftDeletes;

    protected $table = 'slack_integration';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'webhook', 'channel', 'botname', 'icon',
    ];

    public function integrations()
    {
        return $this->belongsToMany(Server::class, 'integration_server', 'slack_id', 'server_id')->withTimestamps();
    }
}
