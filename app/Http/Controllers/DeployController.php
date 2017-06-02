<?php

namespace App\Http\Controllers;

use App\Models\Deploy;
use App\Models\Server;
use App\Models\Task;
use App\Http\Requests\RunDeployRequest;
use Illuminate\Http\Request;
use App\Jobs\DeploymentQueueJob;
use App\Libraries\GitLibrary;

class DeployController extends Controller
{

    public function index(Request $request)
    {
        $servers = Server::all();
        $tasks = [];
        $branches = [];

        $selectedServer = $request->get('server_id', -1);
        $selectedTask = $request->get('task_id', -1);
        $selectedBranch = $request->get('branch', -1);

        if ($selectedServer !== -1) {
            $server = $servers->find($request->server_id);

            if (!empty($server)) {
                $tasks = $server->tasks;
                $branches = GitLibrary::branches($server);

                if (empty($tasks->find($selectedTask))) {
                    $selectedTask = -1;
                }

                if (!in_array($selectedBranch, $branches)) {
                    $selectedBranch = -1;
                }
            } else {
                $selectedTask = -1;
                $selectedBranch = -1;
                $selectedServer = -1;
            }
        }

        return view('home', compact(
            'servers',
            'tasks',
            'branches',
            'selectedServer',
            'selectedTask',
            'selectedBranch'
        ));
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
