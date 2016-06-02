<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Fire Blaster</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="css/app.css">
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
                        <a class="mdl-navigation__link" href="/">Home</a>
                        <a class="mdl-navigation__link" href="/command">Commands</a>
                        <a class="mdl-navigation__link" href="/status">Status</a>
                        <a class="mdl-navigation__link" href="/logout">Logout</a>
                    </nav>
                @endif
            </div>
        </header>

        @if (!Auth::guest())
            <div class="mdl-layout__drawer mdl-layout--small-screen-only">
                <span class="mdl-layout-title">Menu</span>
                <nav class="mdl-navigation">
                    <a class="mdl-navigation__link" href="/">Home</a>
                    <a class="mdl-navigation__link" href="/command">Commands</a>
                    <a class="mdl-navigation__link" href="/status">Status</a>
                    <a class="mdl-navigation__link" href="/logout">Logout</a>
                </nav>
            </div>
        @endif

        <main class="mdl-layout__content">
            @yield('content')
        </main>
    </div>

    <script src="js/vendors.js"></script>
</body>
</html>
