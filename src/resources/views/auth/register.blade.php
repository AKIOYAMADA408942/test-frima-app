@extends('layouts.auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css')}}">
@endsection

@section('tittle')
<title>フリマアプリ ユーザー登録</title>
@endsection

@section('content')
<div class="register-content">
    <h2 class="register-content__heading">会員登録</h2>
    <div class="register-form__inner">
        <form class="register-form__form" action="/register" method="post">
            @csrf
            <div class="register-form__group">
                <label class="register-form__label" for="name">ユーザー名</label>
                <input class="register-form__input" type="text" name="name" id="name" value="{{ old('name') }}">
                @error('name')
                    <p class="register-form__error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="register-form__group">
                <label class="register-form__label" for="postal_code">メールアドレス</label>
                <input class="register-form__input" type="email" name="email" id="email" value="{{ old('email') }}">
                @error('email')
                    <p class="register-form__error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="register-form__group">
                <label class="register-form__label" for="password">パスワード</label>
                <input class="register-form__input" type="password" name="password" id="password">
                @error('password')
                    <p class="register-form__error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="register-form__group">
                <label class="register-form__label" for="password_confirmation">確認用パスワード</label>
                <input class="register-form__input" type="password" id="password_confirmation" name="password_confirmation">
                @error('password')
                    <p class="register-form__error-message">{{ $message }}</p>
                @enderror
            </div>
            <input class="register-form__btn" type="submit" value="登録する">
        </form>
    </div>
    <a  class="login-link" href="/login">ログインはこちら</a>
</div>
@endsection