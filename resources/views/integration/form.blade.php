@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--6-col-desktop mdl-cell--3-offset-desktop">

                @if($integration->exists)
                    <form action="{{ route('integration.update', $integration) }}" method="post">
                        {{ method_field('PUT') }}
                @else
                    <form action="{{ route('integration.store') }}" method="post">
                @endif
                        {{ csrf_field() }}

                        @if($integration->exists)
                            <h3 class="mdl-typography--headline">Edit the integration data.</h3>
                        @else
                            <h3 class="mdl-typography--headline">Fill with the integration data.</h3>
                        @endif

                        <div class="mdl-grid">
                            <div class="mdl-cell mdl-cell--6-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{ $errors->first('name') ? ' is-invalid' : '' }}">
                                    <input class="mdl-textfield__input" type="text" id="name" name="name" value="{{ $integration->name }}">
                                    <label class="mdl-textfield__label" for="name">Integration name</label>
                                </div>
                            </div>

                            <div class="mdl-cell mdl-cell--6-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{ $errors->first('channel') ? ' is-invalid' : '' }}">
                                    <input class="mdl-textfield__input" type="text" id="channel" name="channel" value="{{ $integration->channel }}">
                                    <label class="mdl-textfield__label" for="channel">Channel</label>
                                </div>
                            </div>
                        </div>

                        <div class="mdl-grid">
                            <div class="mdl-cell mdl-cell--6-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{ $errors->first('integration') ? ' is-invalid' : '' }}" >
                                    <input class="mdl-textfield__input" type="text" id="icon" name="icon" value="{{ $integration->icon }}">
                                    <label class="mdl-textfield__label" for="icon">Icon</label>
                                </div>
                            </div>

                            <div class="mdl-cell mdl-cell--6-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{ $errors->first('botname') ? ' is-invalid' : '' }}" >
                                    <input class="mdl-textfield__input" type="text" id="botname" name="botname" value="{{ $integration->botname }}">
                                    <label class="mdl-textfield__label" for="botname">Botname</label>
                                </div>
                            </div>
                        </div>

                        <div class="mdl-grid">
                            <div class="mdl-cell mdl-cell--12-col">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label  mdl-textfield--full-width  {{ $errors->first('webhook') ? ' is-invalid' : '' }}">
                                    <textarea class="mdl-textfield__input" id="webhook" name="webhook"  rows= "3">{{ $integration->webhook }}</textarea>
                                    <label class="mdl-textfield__label" for="webhook">Webhook</label>
                                </div>
                            </div>
                        </div>


                        <div class="mdl-grid">
                            <div class="mdl-cell--12-col text-right">
                                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" type="submmit">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@endsection
