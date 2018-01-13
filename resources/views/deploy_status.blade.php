@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--8-col-desktop mdl-cell--2-offset-desktop">
                <h3 class="mdl-typography--headline">Deploy number {{$deploy->id}}</h3>

                <div class="mdl-grid">
                    <div class="mdl-cell mdl-cell--12-col">
                        <ul class="demo-list-two mdl-list">
                            <li class="mdl-list__item ">
                                <span class="mdl-list__item-primary-content">
                                    <span class="">Server name:</span>
                                </span>

                                <span class="mdl-list__item-secondary-content">
                                    <span><a href="http://{{ $deploy->serverWithTrashed->name }}" target="_blank">{{ $deploy->serverWithTrashed->name }}</a></span>
                                </span>
                            </li>

                            <li class="mdl-list__item">
                                <span class="mdl-list__item-primary-content">
                                    <span class="">Branch name:</span>
                                </span>

                                <span class="mdl-list__item-secondary-content">
                                    <span>{{ $deploy->branch }}</span>
                                </span>
                            </li>

                            <li class="mdl-list__item">
                                <span class="mdl-list__item-primary-content">
                                    <span class="">Status:</span>
                                </span>

                                @if ($deploy->status === 'error')
                                    <a 
                                        id="retry-btn" 
                                        href="{{ route('post.deploy', [ 'server_id' => $deploy->server_id, 'task_id' => $deploy->task_id, 'branch' => $deploy->branch ]) }}" 
                                        class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored"
                                    >
                                        <i class="material-icons">refresh</i>
                                    </a>

                                    <div class="mdl-tooltip" data-mdl-for="retry-btn">Retry Task</div>
                                @endif

                                <span class="mdl-list__item-secondary-content">
                                    <span class="status status-{{ $deploy->status }}" id="status">
                                        {{ ucfirst($deploy->status) }}
                                    </span>
                                </span>
                            </li>
                        </ul>

                        <div class="code w100" id="output">
                            @foreach ($deploy->outputs as $output)
                                {!! nl2br($output->output) !!}
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    @parent
    <script type="text/javascript" src="{{ elixir('js/pages/deploy_status.js') }}"></script>

@endsection
