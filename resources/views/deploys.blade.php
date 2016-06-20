@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--12-col-desktop">
                <h3 class="mdl-typography--headline">History</h3>

                <div class="mdl-tabs mdl-js-tabs">
                    <div class="mdl-tabs__tab-bar">
                        @foreach($servers as $key => $server)
                            <a href="#{{ $server->nameForId }}" class="mdl-tabs__tab {{ $key == 0 ? 'is-active' : '' }}">{{ $server->name }}</a>
                        @endforeach
                    </div>

                    @foreach($servers as $key => $server)
                        <div class="mdl-tabs__panel {{ $key == 0 ? 'is-active' : '' }}" id="{{ $server->nameForId }}">
                            @if(count($server->deploys) > 0)
                                <table class="mdl-data-table mdl-js-data-table w100">
                                    <thead>
                                        <tr>
                                            <th class="mdl-data-table__cell--non-numeric">Task Name</th>
                                            <th class="mdl-data-table__cell--non-numeric">Branch</th>
                                            <th class="mdl-data-table__cell--non-numeric">Executed by</th>
                                            <th class="mdl-data-table__cell--non-numeric">Status</th>
                                            <th class="mdl-data-table__cell--non-numeric">Finished</th>
                                            <th class="mdl-data-table__cell--non-numeric">Output</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($server->deploys as $deploy)
                                            <tr>
                                                <td class="mdl-data-table__cell--non-numeric">{{ $deploy->taskWithTrashed ? $deploy->taskWithTrashed->name : '' }}</td>

                                                <td class="mdl-data-table__cell--non-numeric">{{ $deploy->branch }}</td>
                                                <td class="mdl-data-table__cell--non-numeric">{{ $deploy->user->name }}</td>
                                                <td class="mdl-data-table__cell--non-numeric ">
                                                    <span class="status status-{{ $deploy->status }}">
                                                        {{ ucfirst($deploy->status) }}
                                                    </span>
                                                </td>
                                                <td class="mdl-data-table__cell--non-numeric">{{ $deploy->finished_at ? $deploy->finished_at->format('d/m/Y H:i:s') : '' }}</td>
                                                <td class="mdl-data-table__cell--non-numeric">
                                                    @if(! $deploy->outputs->isEmpty())
                                                        <div class="code">
                                                            {!! $deploy->shortOutput !!}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('deploy.status', $deploy)}}" class="mdl-button mdl-js-button mdl-button--icon">
                                                        <i class="material-icons">add</i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <h6 class="simple-message">No deploys found for this server.</h6>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
