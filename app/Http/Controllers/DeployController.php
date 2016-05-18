<?php

namespace App\Http\Controllers;

use App\Jobs\DeploymentQueueJob;
use Illuminate\Http\Request;
use SSH;

use App\Http\Requests;
use Log;
use Session;
use Config;
use File;

class DeployController extends Controller
{
    public function index()
    {
    	$branches = [];
    	$servers = [];

    	$connections = Config::get('remote.connections');
    	foreach ($connections as $key => $value) {
    		$servers[] = $key;
    	}

    	if (!Session::has('branches')){
    		SSH::run([
			    'cd /vagrant',
			    'git branch',
			], function($line)
			{
			    $branches = explode(PHP_EOL, $line);
			    foreach ($branches as $key => $value) {
			    	$branches[$key] = str_replace(['*', ' '], "", $value);
			    	if (empty($branches[$key])){
			    		unset($branches[$key]);
			    	}
			    }
			    Session::put('branches', $branches);
			});
    	}

        return view('layout', ['branches' => Session::get('branches'), 'servers' => $servers]);
    }

    public function deployIt(Request $request)
    {
    	$branch = $request->input('branch');
    	$server = $request->input('server');

    	$this->dispatch(new DeploymentQueueJob($server, $branch));
    	return redirect('/');
    }

    public function deployCommand(Request $request){
    	$commands = File::get( '../deploy_command' );
    	return view('command', ['commands' => $commands]);
    }
}
