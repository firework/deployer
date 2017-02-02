<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\SlackIntegration;
use App\Http\Requests\SlackIntegrationRequest;

class SlackIntegrationController extends Controller
{
    public function index()
    {
        $integrations = SlackIntegration::all();
        return view('integration.index', compact('integrations'));
    }

    public function create()
    {
        $integration = new SlackIntegration();
        return view('integration.form', compact('integration'));
    }

    public function store(SlackIntegrationRequest $request)
    {
        $integration = new SlackIntegration($request->all());

        $integration->save();

        return redirect('integration');
    }

    public function edit(SlackIntegration $integration)
    {
        return view('integration.form', compact('integration'));
    }

    public function update(SlackIntegrationRequest $request, SlackIntegration $integration)
    {
        $integration->fill($request->all());
        $integration->save();
        return redirect('integration');
    }

    public function destroy(SlackIntegration $integration)
    {
        $integration->delete();
        return redirect('integration');
    }
}
