@extends('layouts.main')

<!-- Main Content -->
@section('content')
    <div class="mdl-grid">
        <div class="mdl-layout-spacer"></div>

        <div class="mdl-cell mdl-cell--5-col">
            <h3 class="mdl-typography--headline">Reset password</h3>

            @if (session('status'))
                <div>
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ url('/password/email') }}">
                {{ csrf_field() }}

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                    <input class="mdl-textfield__input" type="email" id="email">
                    <label class="mdl-textfield__label" for="sample3">E-Mail Address</label>
                </div>

                <br>

                <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" type="submmit">
                    Reset
                </button>
            </form>
        </div>

        <div class="mdl-layout-spacer"></div>
    </div>
@endsection
