@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--10-col-desktop mdl-cell--1-offset-desktop">
                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--9-col">
                        <h3 class="mdl-typography--headline">Slack Integrations</h3>
                    </div>

                    <div class="mdl-cell mdl-cell--3-col mdl-cell--middle text-right">
                        <a href="{{ route('integration.create') }}">
                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                                New Integration
                            </button>
                        </a>
                    </div>
                </div>

                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--12-col">
                        @if($integrations->count() > 0)
                            <table class="mdl-data-table mdl-js-data-table w100">
                                <thead>
                                    <tr>
                                        <th class="mdl-data-table__cell--non-numeric">Integration Name</th>
                                        <th class="mdl-data-table__cell--non-numeric">Webhook</th>
                                        <th class="mdl-data-table__cell--non-numeric">Channel</th>
                                        <th class="mdl-data-table__cell--non-numeric">Botname</th>
                                        <th class="mdl-data-table__cell--non-numeric">Icon</th>
                                        <th class="mdl-data-table__cell--non-numeric">Edit</th>
                                        <th class="mdl-data-table__cell--non-numeric">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($integrations as $integration)
                                        <tr>
                                            <td class="mdl-data-table__cell--non-numeric">{{ $integration->name }}</td>
                                            <td class="mdl-data-table__cell--non-numeric"><a href="{{ $integration->webhook }}">Link</a></td>
                                            <td class="mdl-data-table__cell--non-numeric">{{ $integration->channel }}</td>
                                            <td class="mdl-data-table__cell--non-numeric">{{ $integration->botname }}</td>
                                            <td class="mdl-data-table__cell--non-numeric">{{ $integration->icon }}</td>
                                            <td class="mdl-data-table__cell--non-numeric">
                                                <a href="{{ route('integration.edit', $integration->id) }}" class="mdl-button mdl-js-button mdl-button--icon">
                                                    <i class="material-icons">mode_edit</i>
                                                </a>
                                            </td>
                                            <td class="mdl-data-table__cell--non-numeric">
                                                <a href="{{ route('integration.destroy', $integration->id) }}" class="mdl-button mdl-js-button mdl-button--icon">
                                                    <i class="material-icons">delete</i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h5 class="simple-message">No integration found.</h5>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
