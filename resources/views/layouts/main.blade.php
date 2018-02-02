<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fire Blaster</title>
    <link rel="shortcut icon" type="image/png" href="{{ url('/img/favicon-16x16.png') }}" sizes="16x16">
    <link rel="shortcut icon" type="image/png" href="{{ url('/img/favicon-32x32.png') }}" sizes="32x32">
    <link rel="shortcut icon" type="image/png" href="{{ url('/img/favicon-48x48.png') }}" sizes="48x48">
    <link rel="shortcut icon" type="image/png" href="{{ url('/img/favicon-96x96.png') }}" sizes="96x96">
    <link rel="shortcut icon" type="image/png" href="{{ url('/img/favicon.png') }}">
    <link rel="apple-touch-icon" sizes="57x57" href="{{ url('/img/apple-touch-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ url('/img/apple-touch-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ url('/img/apple-touch-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ url('/img/apple-touch-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ url('/img/apple-touch-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ url('/img/apple-touch-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ url('/img/apple-touch-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ url('/img/apple-touch-icon-152x152.png') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
</head>
<body>
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
        <header class="mdl-layout__header">
            <div class="mdl-layout__header-row">
                <span class="mdl-layout-title">
                    <a href="/" class="brand-link"> Fire Blaster 🚀</a>
                </span>

                <div class="mdl-layout-spacer"></div>
                @if (!Auth::guest())
                    <nav class="mdl-navigation mdl-layout--large-screen-only">
                        <a class="mdl-navigation__link" href="{{ route('home') }}">Home</a>
                        <a class="mdl-navigation__link" href="{{ route('integration.index') }}">Integrations</a>
                        <a class="mdl-navigation__link" href="{{ route('server.index') }}">Servers</a>
                        <a class="mdl-navigation__link" href="{{ route('task.index') }}">Tasks</a>
                        <a class="mdl-navigation__link" href="{{ route('deploys') }}">Deploys</a>
                        <a class="mdl-navigation__link" href="/logout">Logout</a>
                    </nav>
                @endif
            </div>
        </header>

        @if (!Auth::guest())
            <div class="mdl-layout__drawer mdl-layout--small-screen-only">
                <span class="mdl-layout-title">Menu</span>
                <nav class="mdl-navigation">
                    <a class="mdl-navigation__link" href="{{ route('home') }}">Home</a>
                    <a class="mdl-navigation__link" href="{{ route('server.index') }}">Servers</a>
                    <a class="mdl-navigation__link" href="{{ route('task.index') }}">Tasks</a>
                    <a class="mdl-navigation__link" href="{{ route('deploys') }}">Deploys</a>
                    <a class="mdl-navigation__link" href="/logout">Logout</a>
                </nav>
            </div>
        @endif

        <main class="mdl-layout__content">
            @yield('content')
        </main>
    </div>

    <dialog class="mdl-dialog">
	    <div class="mdl-dialog__content">
	        <p>Are you sure?</p>
	    </div>

	    <div class="mdl-dialog__actions">
	        <button type="button" class="mdl-button accept">Yes</button>
	        <button type="button" class="mdl-button close">Cancel</button>
	    </div>
	</dialog>

    @section('scripts')
        <script src="{{ mix('js/vendor/global.js') }}"></script>
    @show
</body>
</html>
