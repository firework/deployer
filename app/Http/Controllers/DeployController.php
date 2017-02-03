<?php

namespace App\Http\Controllers;

use App\Models\Deploy;
use App\Models\Server;
use App\Models\Task;
use App\Http\Requests\RunDeployRequest;
use Illuminate\Http\Request;
use App\Jobs\DeploymentQueueJob;

class DeployController extends Controller
{

    public function index()
    {
        $servers =  Server::all();
        $tasks = Task::all();

        return view('home', compact('servers', 'tasks'));
    }

    public function deployIt(RunDeployRequest $request)
    {
        $deploy = Deploy::create([
            'server_id' => $request->server_id,
            'task_id'   => $request->task_id,
            'user_id'   => $request->user()->id,
            'branch'    => $request->branch,
            'status'    => 'todo'
        ]);

        $this->dispatch(new DeploymentQueueJob($deploy));

    	return redirect()->route('deploy.status', [$deploy->id]);
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
