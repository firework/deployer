@extends('layouts.main')

@section('content')
    <div class="mdl-grid">
        <div class="mdl-layout-spacer"></div>

        <div class="mdl-cell mdl-cell--4-col">
            <h3 class="mdl-typography--headline">Login</h3>

            <form method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{ $errors->has('email') ? 'is-invalid' : '' }}">
                    <input class="mdl-textfield__input " type="email" id="email" name="email">
                    <label class="mdl-textfield__label" for="email">E-mail Address</label>

                    @if ($errors->has('email'))
                        <span class="mdl-textfield__error">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-textfield--full-width {{ $errors->has('password') ? 'is-invalid' : '' }}">
                    <input type="password" class="mdl-textfield__input" name="password" id="password" >
                    <label for="password" class="mdl-textfield__label">Password</label>

                    @if ($errors->has('password'))
                        <span class="mdl-textfield__error">{{ $errors->first('password') }}</span>
                    @endif
                </div>

                <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="remember">
                    <input type="checkbox" id="remember" class="mdl-checkbox__input" name="remember">
                    <span class="mdl-checkbox__label">Remeber me</span>
                </label>

                <button type="submit" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                    Login
                </button>

            <a class="" href="{{ url('/password/reset') }}">Forgot Your Password?</a>

            </form>
        </div>
        <div class="mdl-layout-spacer"></div>

    </div>
@endsection
