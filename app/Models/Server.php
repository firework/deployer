<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Server extends Model
{
    use SoftDeletes;

    protected $table = 'servers';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'host', 'username', 'password', 'path', 'key', 'keytext', 'keyphrase', 'timeout', 'agent'
    ];

    public function deploys()
    {
        return $this->hasMany(Deploy::class)->orderBy('updated_at', 'desc');
    }

    public function getNameForIdAttribute()
    {
        return str_slug($this->name);
    }
}
