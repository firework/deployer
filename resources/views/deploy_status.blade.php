@extends('layouts.main')

@section('content')

    <div class="mdl-grid">
        <div class="mdl-layout-spacer"></div>
        
        <div class="mdl-cell mdl-cell--6-col">
            <h3 class="mdl-typography--headline">Deploy number {{$deploy->id}}</h3>

            <ul class="demo-list-two mdl-list">
                <li class="mdl-list__item mdl-list__item--two-line">
                    <span class="mdl-list__item-primary-content">
                        <span class="">Server name:</span>
                    </span>

                    <span class="mdl-list__item-secondary-content">
                        <span>{{ $deploy->serverWithTrashed->name }}</span>
                    </span>
                </li>

                <li class="mdl-list__item mdl-list__item--two-line">
                    <span class="mdl-list__item-primary-content">
                        <span class="">Branch name:</span>
                    </span>

                    <span class="mdl-list__item-secondary-content">
                        <span>{{ $deploy->branch }}</span>
                    </span>
                </li>

                <li class="mdl-list__item mdl-list__item--two-line">
                    <span class="mdl-list__item-primary-content">
                        <span class="">Status:</span>
                    </span>

                    <span class="mdl-list__item-secondary-content">
                        <span>{{ $deploy->status }}</span>
                    </span>
                </li>
            </ul>

            @if(! $deploy->outputs->isEmpty())
                <div class="code w100">
                    @foreach ($deploy->outputs as $output)
                        {!! nl2br($output->output) !!}
                    @endforeach
                </div>
            @endif
        </div>

        <div class="mdl-layout-spacer"></div>
    </div>
@endsection
