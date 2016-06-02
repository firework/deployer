@extends('layouts.main')

@section('content')
    <div class="mdl-grid">
        <div class="mdl-layout-spacer"></div>

        <div class="mdl-cell mdl-cell--5-col">
            <h3 class="mdl-typography--headline">Commands</h3>

            <form method="POST" action="save_command">
                {{ csrf_field() }}

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width">
                    <textarea name="command" class="mdl-textfield__input" rows="10">{{$commands}}</textarea>
                    <label class="mdl-textfield__label" for="command">Deployment commands</label>
                </div>

                <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                    Save
                </button>
            </form>
        </div>

        <div class="mdl-layout-spacer"></div>
    </div>
@endsection
