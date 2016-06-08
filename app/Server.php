<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Server extends Model
{
    use SoftDeletes;

    protected $table = 'servers';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'host', 'username', 'password', 'path'
    ];

    public function deploys()
    {
        return $this->hasMany(Deploy::class);
    }
}
