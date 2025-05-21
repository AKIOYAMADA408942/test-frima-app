@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css')}}">
@endsection

@section('tittle')
<title>フリマアプリ プロフィール編集</title>
@endsection

@section('content')
<div class="profile-content">
    <h2 class="profile-content__heading">プロフィール設定</h2>
    <div class="profile-form__inner">
        <form class="profile-form__form" action="/mypage/profile" method="post" enctype="multipart/form-data">
            @csrf
            <div class="profile-form__group-image">
                <img class="profile-form__image" src="{{ $user->thumbnail_path}}">
                <label class="profile-form__label-image" for="thumbnail">画像を選択する</label>
                <input class="profile-form__input-file" type="file" name="thumbnail" id="thumbnail">
                @error('thumbnail')
                    <p class="profile-form__error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="profile-form__group">
                <label class="profile-form__label" for="name">ユーザー名</label>
                <input class="profile-form__input" type="text" name="name" id="name" value="{{ old('name',$user->name) }}">
                @error('name')
                    <p class="profile-form__error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="profile-form__group">
                <label class="profile-form__label" for="postal_code">郵便番号</label>
                <input class="profile-form__input" type="text" name="postal_code" id="postal_code" value="{{ $user->postal_code }}">
            </div>
            <div class="profile-form__group">
                <label class="profile-form__label" for="address">住所</label>
                <input class="profile-form__input" type="text" name="address" id="address" value="{{ $user->address }}">
            </div>
            <div class="profile-form__group">
                <label class="profile-form__label" for="building">建物名</label>
                <input class="profile-form__input" type="text" name="building" id="building" value="{{ $user->building }}">
            </div>
            <input class="profile-form__btn" type="submit" value="更新する">
        </form>
    </div>
</div>
@endsection