<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deploy extends Model
{
    protected $table = 'deploy';

    public function outputs()
    {
        return $this->hasMany('App\DeployOutputs');
    }
}
