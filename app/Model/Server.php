<?php

namespace App\Model;

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
        return $this->hasMany(Deploy::class)->orderBy('updated_at', 'desc');
    }

    public function getNameForIdAttribute()
    {
        $name = $this->name;
        $name = trim($name);
        $name = strtolower($name);
        $name = str_replace(' ', '_', $name);

        return $name;
    }
}
