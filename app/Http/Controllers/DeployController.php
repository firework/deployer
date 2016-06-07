<?php

namespace App\Http\Controllers;

use App\Deploy;
use App\Jobs\DeploymentQueueJob;
use Illuminate\Http\Request;
use App\Libraries\GitLibrary;
use App\Server;

use App\Http\Requests;
use Log;
use Storage;

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

    public function deployIt(Request $request)
    {
        $deploy = Deploy::create($request->all());
        $this->dispatch(new DeploymentQueueJob($deploy));
    	return redirect('/status');
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

    public function status(Request $request)
    {
        $deploys = Deploy::with(['outputs', 'server'])->orderBy('updated_at', 'desc')->get();

        Log::info($deploys);
        return view('status', compact('deploys'));
    }
}
