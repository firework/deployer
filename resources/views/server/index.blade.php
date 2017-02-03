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
                    <div class="mdl-cell mdl-cell--9-col">
                        <h3 class="mdl-typography--headline">Servers</h3>
                    </div>

                    <div class="mdl-cell mdl-cell--3-col mdl-cell--middle text-right">
                        <a href="{{ route('server.create') }}">
                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                                New Server
                            </button>
                        </a>
                    </div>
                </div>

                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--12-col">
                        @if($servers->count() > 0)
                            <table class="mdl-data-table mdl-js-data-table w100">
                                <thead>
                                    <tr>
                                        <th class="mdl-data-table__cell--non-numeric">Server Name</th>
                                        <th class="mdl-data-table__cell--non-numeric">Host</th>
                                        <th class="mdl-data-table__cell--non-numeric">Username</th>
                                        <th class="mdl-data-table__cell--non-numeric">Path</th>
                                        <th class="mdl-data-table__cell--non-numeric">Edit</th>
                                        <th class="mdl-data-table__cell--non-numeric">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($servers as $server)
                                        <tr>
                                            <td class="mdl-data-table__cell--non-numeric">{{ $server->name }}</td>
                                            <td class="mdl-data-table__cell--non-numeric">{{ $server->host }}</td>
                                            <td class="mdl-data-table__cell--non-numeric">{{ $server->username }}</td>
                                            <td class="mdl-data-table__cell--non-numeric">{{ $server->path }}</td>
                                            <td class="mdl-data-table__cell--non-numeric">
                                                <a href="{{ route('server.edit', $server->id) }}" class="mdl-button mdl-js-button mdl-button--icon">
                                                    <i class="material-icons">mode_edit</i>
                                                </a>
                                            </td>
                                            <td class="mdl-data-table__cell--non-numeric">
                                                <a href="{{ route('server.destroy', $server->id) }}" class="mdl-button mdl-js-button mdl-button--icon delete-button">
                                                    <i class="material-icons">delete</i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h5 class="simple-message">No servers found.</h5>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
