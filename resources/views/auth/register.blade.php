@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="mdl-grid">
            <div class="mdl-cell mdl-cell--4-col-desktop mdl-cell--4-offset-desktop">
                <h3 class="mdl-typography--headline">Register</h3>

                <form action="{{ url('/register')}}" method="POST">
                    {{ csrf_field() }}

                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{ $errors->has('name') ? 'is-invalid' : '' }}">
                        <input class="mdl-textfield__input" type="name" id="name" name="name">
                        <label class="mdl-textfield__label" for="name">Name</label>

                        @if ($errors->has('name'))
                            <span class="mdl-textfield__error">{{ $errors->first('name') }}</span>
                        @endif
                    </div>

                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{ $errors->has('email') ? 'is-invalid' : '' }}">
                        <input class="mdl-textfield__input" type="email" id="email" name="email">
                        <label class="mdl-textfield__label" for="email">E-mail Address</label>

                        @if ($errors->has('email'))
                            <span class="mdl-textfield__error">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{ $errors->has('password') ? 'is-invalid' : '' }}">
                        <input class="mdl-textfield__input" type="password" id="password" name="password">
                        <label class="mdl-textfield__label" for="password">Password</label>

                        @if ($errors->has('password'))
                            <span class="mdl-textfield__error">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}">
                        <input class="mdl-textfield__input" type="password" id="password_confirmation" name="password_confirmation">
                        <label class="mdl-textfield__label" for="password_confirmation">Confirm Password</label>

                        @if ($errors->has('password_confirmation'))
                            <span class="mdl-textfield__error">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                    </div>

                    <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                        Register
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
