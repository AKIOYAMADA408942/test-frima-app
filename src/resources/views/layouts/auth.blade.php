<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{ asset('css/common.css')}}">
    @yield('css')
    @yield('tittle')
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a href="/">
                <img class="header-logo" src="{{ asset('img/logo.svg')}}">
            </a>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>