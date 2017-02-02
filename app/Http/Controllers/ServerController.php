<?php

namespace App\Http\Controllers;


use App\Models\Server;
use App\Models\SlackIntegration;
use Illuminate\Http\Request;
use App\Http\Requests\ServerRequest;

class ServerController extends Controller
{
    public function index()
    {
        $servers = Server::all();
        return view('server.index', compact('servers'));
    }

    public function create()
    {
        $server = new Server();
        $integrations = SlackIntegration::all()->lists('name', 'id');
        return view('server.form', compact('server', 'integrations'));
    }

    public function store(ServerRequest $request)
    {
        $server = new Server($request->all());

        if ($server->timeout < 30) {
            $server->timeout = 30;
        }

        $server->save();
        $server->integrations()->sync($request->get('integrations', []));

        return redirect('server');
    }

    public function edit(Server $server)
    {
        $integrations = SlackIntegration::all()->lists('name', 'id');

        return view('server.form', compact('server', 'integrations'));
    }

    public function update(ServerRequest $request, Server $server)
    {
        $server->save($request->all());

        $server->integrations()->sync($request->get('integrations', []));

        return redirect('server');
    }

    public function destroy(Server $server)
    {
        $server->delete();
        return redirect('server');
    }
}
