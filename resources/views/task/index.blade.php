@extends('layouts.main')

@section('scripts')
	@parent
	<script type="text/javascript" src="{{ elixir('js/pages/delete_dialog.js') }}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--10-col-desktop mdl-cell--1-offset-desktop">
                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--10-col">
                        <h3 class="mdl-typography--headline">Tasks</h3>
                    </div>

                    <div class="mdl-cell mdl-cell--2-col mdl-cell--middle text-right">
                        <a href="{{ route('task.create') }}">
                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" >New Task</button>
                        </a>
                    </div>
                </div>

                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--12-col">
                        @if($tasks->count() > 0)
                            <table class="mdl-data-table mdl-js-data-table w100">
                                <thead>
                                    <tr>
                                        <th class="mdl-data-table__cell--non-numeric">Task Name</th>
                                        <th class="mdl-data-table__cell--non-numeric">Commands</th>
                                        <th class="mdl-data-table__cell--non-numeric">Edit</th>
                                        <th class="mdl-data-table__cell--non-numeric">Delete</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($tasks as $task)
                                        <tr>
                                            <td class="mdl-data-table__cell--non-numeric">{{ $task->name }}</td>
                                            <td class="mdl-data-table__cell--non-numeric">
                                                <div class="code">
                                                    {!! nl2br($task->commands) !!}
                                                </div>
                                            </td>
                                            <td class="mdl-data-table__cell--non-numeric">
                                                <a href="{{ route('task.edit', $task->id) }}" class="mdl-button mdl-js-button mdl-button--icon">
                                                    <i class="material-icons">mode_edit</i>
                                                </a>
                                            </td>
                                            <td class="mdl-data-table__cell--non-numeric">
                                                <a href="{{ route('task.destroy', $task->id) }}" class="mdl-button mdl-js-button mdl-button--icon delete-button">
                                                    <i class="material-icons">delete</i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h5 class="simple-message">No tasks found.</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
