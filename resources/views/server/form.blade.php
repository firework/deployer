@extends('layouts.main')

@section('content')
    <div class="mdl-grid">
        <div class="mdl-layout-spacer"></div>

        <div class="mdl-cell--4-col">
            @if($server->exists)
                <h3 class="mdl-typography--headline">Edit the server data.</h3>
            @else
                <h3 class="mdl-typography--headline">Fill with the server data.</h3>
            @endif

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($server->exists)
                <form action="{{ route('server.update', $server) }}" method="post">
                    {{ method_field('PUT') }}
            @else
                <form action="{{ route('server.store') }}" method="post">
            @endif

                {{ csrf_field() }}

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{ $errors->first('name') ? ' is-invalid' : '' }}">
                    <input class="mdl-textfield__input" type="text" id="name" name="name" value="{{ $server->name }}">
                    <label class="mdl-textfield__label" for="name">Server name</label>
                </div>

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{ $errors->first('host') ? ' is-invalid' : '' }}">
                    <input class="mdl-textfield__input" type="text" id="host" name="host" value="{{ $server->host }}">
                    <label class="mdl-textfield__label" for="host">Host</label>
                </div>

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{ $errors->first('username') ? ' is-invalid' : '' }}">
                    <input class="mdl-textfield__input" type="text" id="username" name="username" value="{{ $server->username }}">
                    <label class="mdl-textfield__label" for="username">User name</label>
                </div>

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{ $errors->first('password') ? ' is-invalid' : '' }}" >
                    <input class="mdl-textfield__input" id="password" name="password" value="{{ $server->password }}">
                    <label class="mdl-textfield__label" for="password">Password</label>
                </div>

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{ $errors->first('path') ? ' is-invalid' : '' }}">
                    <input class="mdl-textfield__input" type="text" id="path" name="path" value="{{ $server->path }}">
                    <label class="mdl-textfield__label" for="path">Path</label>
                </div>

                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" type="submmit">
                    Save
                </button>
            </form>
        </div>

        <div class="mdl-layout-spacer"></div>
    </div>
    @endsection
