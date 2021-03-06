@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--6-col-desktop mdl-cell--3-offset-desktop">

                @if($server->exists)
                    <form action="{{ route('server.update', $server) }}" method="post">
                        {{ method_field('PUT') }}
                @else
                    <form action="{{ route('server.store') }}" method="post">
                @endif
                        {{ csrf_field() }}

                        @if($server->exists)
                            <h3 class="mdl-typography--headline">Edit the server data.</h3>
                        @else
                            <h3 class="mdl-typography--headline">Fill with the server data.</h3>
                        @endif

                        <div class="mdl-grid">
                            <div class="mdl-cell mdl-cell--6-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{ $errors->first('name') ? ' is-invalid' : '' }}">
                                    <input class="mdl-textfield__input" type="text" id="name" name="name" value="{{ $server->name }}">
                                    <label class="mdl-textfield__label" for="name">Server name</label>
                                </div>
                            </div>

                            <div class="mdl-cell mdl-cell--6-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label  mdl-textfield--full-width  {{ $errors->first('host') ? ' is-invalid' : '' }}">
                                    <input class="mdl-textfield__input" type="text" id="host" name="host" value="{{ $server->host }}">
                                    <label class="mdl-textfield__label" for="host">Host</label>
                                </div>
                            </div>
                        </div>

                        <div class="mdl-grid">
                            <div class="mdl-cell mdl-cell--6-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{ $errors->first('username') ? ' is-invalid' : '' }}">
                                    <input class="mdl-textfield__input" type="text" id="username" name="username" value="{{ $server->username }}">
                                    <label class="mdl-textfield__label" for="username">User name</label>
                                </div>
                            </div>

                            <div class="mdl-cell mdl-cell--6-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{ $errors->first('password') ? ' is-invalid' : '' }}" >
                                    <input class="mdl-textfield__input" id="password" type="password" name="password" value="{{ $server->password }}">
                                    <label class="mdl-textfield__label" for="password">Password</label>
                                </div>
                            </div>
                        </div>

                        <div class="mdl-grid">
                            <div class="mdl-cell mdl-cell--6-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{ $errors->first('timeout') ? ' is-invalid' : '' }}" >
                                    <input class="mdl-textfield__input" id="timeout" pattern="[0-9]*" name="timeout" value="{{ $server->timeout }}">
                                    <label class="mdl-textfield__label" for="timeout">Timeout</label>
                                </div>
                            </div>

                            <div class="mdl-cell mdl-cell--6-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{ $errors->first('agent') ? ' is-invalid' : '' }}" >
                                    <input class="mdl-textfield__input" id="agent" name="agent" value="{{ $server->agent }}">
                                    <label class="mdl-textfield__label" for="agent">Agent</label>
                                </div>
                            </div>
                        </div>

                        <div class="mdl-grid">
                            <div class="mdl-cell mdl-cell--6-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{ $errors->first('path') ? ' is-invalid' : '' }}">
                                    <input class="mdl-textfield__input" type="text" id="path" name="path" value="{{ $server->path }}">
                                    <label class="mdl-textfield__label" for="path">Path</label>
                                </div>
                            </div>

                            <div class="mdl-cell mdl-cell--6-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{ $errors->first('key') ? ' is-invalid' : '' }}" >
                                    <input class="mdl-textfield__input" id="key" type="text" name="key" value="{{ $server->key }}">
                                    <label class="mdl-textfield__label" for="key">Key</label>
                                </div>
                            </div>
                        </div>

                        <div class="mdl-grid">
                            <div class="mdl-cell mdl-cell--12-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width{{ $errors->first('keyphrase') ? ' is-invalid' : '' }}" >
                                    <input class="mdl-textfield__input" id="keyphrase" type="password" name="keyphrase" value="{{ $server->keyphrase }}">
                                    <label class="mdl-textfield__label" for="keyphrase">Key Phrase</label>
                                </div>
                            </div>
                        </div>

                        <div class="mdl-grid">
                            <div class="mdl-cell mdl-cell--12-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{ $errors->first('keytext') ? ' is-invalid' : '' }}" >
                                    <textarea class="mdl-textfield__input" id="keytext" name="keytext"  rows= "3">{{ $server->keytext }}</textarea>
                                    <label class="mdl-textfield__label" for="keytext">Key Text</label>
                                </div>
                            </div>
                        </div>

                        @if($integrations->count() > 0)
                        <div class="mdl-grid">
                            <h5>Slack Integrations</h5>
                        </div>

                        <div class="mdl-grid">
                            @foreach($integrations as $id => $integration)
                                <div class="mdl-cell mdl-cell--6-col">
                                    <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="{{ $id }}">
                                        @if ($server->hasIntegration($id))
                                            <input type="checkbox" id="{{ $id }}" value="{{ $id }}" class="mdl-checkbox__input" name="integrations[]" checked />
                                        @else
                                            <input type="checkbox" id="{{ $id }}" value="{{ $id }}" class="mdl-checkbox__input" name="integrations[]" />
                                        @endif
                                        <span class="mdl-checkbox__label">{{ $integration }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @else
                            <h6 class="simple-message">No integrations found.</h6>
                        @endif

                        <div class="mdl-grid">
                            <div class="mdl-cell--12-col text-right">
                                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" type="submmit">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
