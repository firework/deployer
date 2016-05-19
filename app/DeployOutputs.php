<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeployOutputs extends Model
{
    protected $table = 'deploy_output';
    public $timestamps = false;

    public function deploy()
    {
        return $this->belongsTo('App\Deploy');
    }
}
