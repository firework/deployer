@extends('layouts.main')

@section('content')

    <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--8-col mdl-cell--2-offset">
            <div class="mdl-grid">
                <div class="mdl-cell mdl-cell--10-col">
                    <h3 class="mdl-typography--headline">Tasks</h3>
                </div>

                <div class="mdl-cell mdl-cell--2-col mdl-cell--middle">
                    <a href="{{ route('task.create') }}">
                        <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" >
                            New Task
                        </button>
                    </a>
                </div>

            </div>
        </div>
    </div>

    <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--8-col mdl-cell--2-offset">
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
                              <a href="{{ route('task.edit', $task->id) }}">
                                  <i class="material-icons">mode_edit</i>
                              </a>
                          </td>
                          <td class="mdl-data-table__cell--non-numeric">
                             <a href="{{ route('task.destroy', $task->id) }}">
                                 <i class="material-icons">delete</i>
                             </a>
                         </td>
                      </tr>
                  @endforeach
              </tbody>
            </table>
        </div>
    </div>
@endsection
