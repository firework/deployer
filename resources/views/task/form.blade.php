@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--6-col-desktop mdl-cell--3-offset-desktop">
                @if($task->exists)
                    <form action="{{ route('task.update', $task) }}" method="post">
                        {{ method_field('PUT') }}
                @else
                    <form action="{{ route('task.store') }}" method="post">
                @endif
                        {{ csrf_field() }}

                        @if($task->exists)
                            <h3 class="mdl-typography--headline">Edit the task data.</h3>
                        @else
                            <h3 class="mdl-typography--headline">Fill with the task data.</h3>
                        @endif

                        <div class="mdl-grid">
                            <div class="mdl-cell mdl-cell--12-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width{{ $errors->first('name') ? ' is-invalid' : '' }}" >
                                    <input class="mdl-textfield__input" id="name" type="text" name="name" value="{{ $task->name }}">
                                    <label class="mdl-textfield__label" for="name">Name</label>
                                </div>
                            </div>
                        </div>

                        <div class="mdl-grid">
                            <div class="mdl-cell mdl-cell--12-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{ $errors->first('commands') ? ' is-invalid' : '' }}" >
                                    <textarea class="mdl-textfield__input" id="commands" name="commands"  rows= "10">{{ $task->commands }}</textarea>
                                    <label class="mdl-textfield__label" for="commands">Commands</label>
                                </div>
                            </div>
                        </div>

                        @if($servers->count() > 0)
                        <div class="mdl-grid">
                            <h5>Servers</h5>
                        </div>

                        <div class="mdl-grid">
                            @foreach($servers as $id => $server)
                                <div class="mdl-cell mdl-cell--6-col">
                                    <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="{{ $id }}">
                                        @if ($task->hasServer($id))
                                            <input type="checkbox" id="{{ $id }}" value="{{ $id }}" class="mdl-checkbox__input" name="servers[]" checked />
                                        @else
                                            <input type="checkbox" id="{{ $id }}" value="{{ $id }}" class="mdl-checkbox__input" name="servers[]" />
                                        @endif
                                        <span class="mdl-checkbox__label">{{ $server }}</span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @else
                            <h6 class="simple-message">No servers found.</h6>
                        @endif

                        <div class="mdl-grid">
                            <div class="mdl-cell mdl-cell--12-col text-right">
                                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent text-right" type="submmit">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection
