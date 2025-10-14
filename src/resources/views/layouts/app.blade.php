<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    @yield('css')
    @yield('tittle')
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <a href="/">
                <img class="header-logo" src="{{ asset('img/logo.svg') }}">
            </a>
        </div>
        <form class="header-search" action="{{ route('index') }}" method="get">
            <div class="header-search__inner">
                <input class="header-search__input" type="text" name="keyword" placeholder="なにをお探しですか?" value="{{ session('keyword')}}">
                @if(isset($page) && $page  === 'mylist')
                    <input type="hidden" name="page" value="mylist">
                @endif
            </div>
        </form>
        <nav class="header-nav">
            @if(Auth::check())
            <form class="header-logout" action="/logout" method="post">
                @csrf
                <input type="submit" class="header-logout__btn" value="ログアウト"></input>
            </form>
            @else
            <a class="header-link" href="/login">ログイン</a>
            @endif
            <a class="header-link" href="{{ route('mypage') }}" >マイページ</a>
            <a class="header-link__sell" href="/sell">出品</a>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>