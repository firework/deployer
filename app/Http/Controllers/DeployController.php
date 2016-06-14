<?php

namespace App\Http\Controllers;

use Log;
use Storage;
use App\Model\Deploy;
use App\Model\Server;
use App\Http\Requests;
use App\Http\Requests\RunDeployRequest;
use Illuminate\Http\Request;
use App\Libraries\GitLibrary;
use App\Jobs\DeploymentQueueJob;

class DeployController extends Controller
{

    public function index()
    {
        $branches = [];
        $servers =  Server::all();

        if($servers->count() > 0){
            $branches = GitLibrary::branches();
        }

        return view('main', compact('branches', 'servers'));
    }

    public function deployIt(RunDeployRequest $request)
    {
        $deploy = Deploy::create([
            'server_id' => $request->server_id,
            'user_id'   => $request->user()->id,
            'branch'    => $request->branch,
            'status'    => 'todo'
        ]);

        $this->dispatch(new DeploymentQueueJob($deploy));

    	return view('deploy_status', compact('deploy'));
    }

    public function deployCommand(Request $request){

        $commands = '';

        if(Storage::exists('deploy_command')){
            $commands = Storage::get('deploy_command');
        }

    	return view('command', compact('commands'));
    }

    public function saveCommand(Request $request){
        $commands = Storage::put('deploy_command', $request->input('command'));
        return redirect('/command');
    }

    public function deploys(Request $request)
    {
        $servers = Server::withTrashed()->get();
        return view('deploys', compact('servers'));
    }

    public function deployStatus(Deploy $deploy)
    {
        return view('deploy_status', compact('deploy'));
    }
}
