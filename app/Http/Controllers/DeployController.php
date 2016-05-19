<?php

namespace App\Http\Controllers;

use App\Deploy;
use App\DeployOutputs;
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

        return view('main', ['branches' => Session::get('branches'), 'servers' => $servers]);
    }

    public function deployIt(Request $request)
    {
    	$deploy = new Deploy;
        $deploy->server = $request->input('server');
        $deploy->branch = $request->input('branch');
        $deploy->save();

    	$this->dispatch(new DeploymentQueueJob($deploy->id));
    	return redirect('/status');
    }

    public function deployCommand(Request $request){
    	$commands = File::get( base_path() . '/deploy_command' );
    	return view('command', ['commands' => $commands]);
    }

    public function saveCommand(Request $request){
        $commands = File::put( base_path() . '/deploy_command',  $request->input('command'));
        return redirect('/command');
    }

    public function status(Request $request)
    {
        $deploys = Deploy::with('outputs')->orderBy('updated_at', 'desc')->get();
        Log::info($deploys);
        return view('status', ['deploys' => $deploys]);
    }
}
