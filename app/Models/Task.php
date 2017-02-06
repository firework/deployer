<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $table = 'tasks';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'commands'
    ];

    public function deploys()
    {
        return $this->hasMany(Deploy::class);
    }

    public function servers()
    {
        return $this->belongsToMany(Server::class, 'tasks_servers', 'task_id', 'server_id');
    }

    public function hasServer($id)
    {
        return in_array($id, $this->servers->modelKeys());
    }
}
