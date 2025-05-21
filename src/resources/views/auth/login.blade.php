@extends('layouts.auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css')}}">
@endsection

@section('tittle')
<title>フリマアプリ ユーザーログイン</title>
@endsection

@section('content')
<div class="login-content">
    <h2 class="login-content__heading">ログイン</h2>
    <div class="login-form__inner">
        <form class="login-form__form" action="/login" method="post">
            @csrf
            <div>
                <label class="login-form__label" for="email">メールアドレス</label>
                <input class="login-form__input" type="email" name="email" id="email" value="{{ old('email') }}">
                @error('email')
                    <p class="login-form__error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="login-form__group">
                <label class="login-form__label" for="password">パスワード</label>
                <input class="login-form__input" type="password" name="password" id="password">
                @error('password')
                    <p class="login-form__error-message">{{ $message }}</p>
                @enderror
            </div>
            <input class="login-form__btn" type="submit" value="ログインする">
        </form>
    </div>
    <a  class="register-link" href="/register">会員登録はこちら</a>
</div>
@endsection