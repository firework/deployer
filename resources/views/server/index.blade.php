@extends('layouts.main')

@section('content')

    <div class="mdl-grid">
        <div class="mdl-layout-spacer"></div>

        <div class="mdl-cell mdl-cell--6-col">
            <h3 class="mdl-typography--headline">Servers</h3>
        </div>

        <div class="mdl-cell mdl-cell--2-col mdl-cell--middle">
            <a href="{{ route('server.create') }}">
                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" >
                    New Server
                </button>
            </a>
        </div>

        <div class="mdl-layout-spacer"></div>
    </div>

    <div class="mdl-grid">
        <div class="mdl-layout-spacer"></div>

        <div class="mdl-cell mdl-cell--8-col">
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
                              <a href="{{ route('server.edit', $server->id) }}">
                                  <i class="material-icons">mode_edit</i>
                              </a>
                          </td>
                          <td class="mdl-data-table__cell--non-numeric">
                             <a href="{{ route('server.destroy', $server->id) }}">
                                 <i class="material-icons">delete</i>
                             </a>
                         </td>
                      </tr>
                  @endforeach
              </tbody>
            </table>
        </div>

        <div class="mdl-layout-spacer"></div>
    </div>
@endsection
