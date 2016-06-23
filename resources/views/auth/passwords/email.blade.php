@extends('layouts.main')

<!-- Main Content -->
@section('content')
    <div class="container">
        <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--4-col-desktop mdl-cell--4-offset-desktop">
                <h3 class="mdl-typography--headline">Reset password</h3>

                @if (session('status'))
                    <div>
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ url('/password/email') }}">
                    {{ csrf_field() }}

                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{ $errors->has('email') ? 'is-invalid' : '' }}">
                        <input class="mdl-textfield__input " type="email" id="email" name="email">
                        <label class="mdl-textfield__label" for="email">E-mail Address</label>

                        @if ($errors->has('email'))
                            <span class="mdl-textfield__error">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" type="submmit">
                        Reset
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
