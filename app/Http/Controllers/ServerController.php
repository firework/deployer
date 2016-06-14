<?php

namespace App\Http\Controllers;


use App\Model\Server;
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
        return view('server.form', compact('server'));
    }

    public function store(ServerRequest $request)
    {
        Server::create($request->all());
        return redirect('server');
    }

    public function edit(Server $server)
    {
        return view('server.form', compact('server'));
    }

    public function update(ServerRequest $request, Server $server)
    {
        $server->fill($request->all());
        $server->save();
        return redirect('server');
    }

    public function destroy(Server $server)
    {
        $server->delete();
        return redirect('server');
    }
}
