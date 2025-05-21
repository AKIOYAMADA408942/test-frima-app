@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css')}}">
@endsection

@section('tittle')
<title>フリマアプリ 住所変更</title>
@endsection

@section('content')
<div class="address-content">
    <h2 class="address-content__heading">住所変更</h2>
    <div class="address-form__inner">
        <form class="address-form__form" action="/purchase/address/{{ $item_id }}" method="post">
            @csrf
            <div class="address-form__group">
                <label class="address-form__label" for="postal_code">郵便番号</label>
                <input class="address-form__input" type="text" name="postal_code" id="postal_code" value="{{ old('postal_code',$user->postal_code) }}">
                @error('postal_code')
                    <p class="address-form__error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="address-form__group">
                <label class="address-form__label" for="address">住所</label>
                <input class="address-form__input" type="input" name="address" id="address" value="{{ old('address',$user->address) }}">
                @error('address')
                    <p class="address-form__error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="address-form__group">
                <label class="address-form__label" for="building">建物名</label>
                <input class="address-form__input" type="text" name="building" id="building" value="{{ old('building',$user->building) }}">
                @error('building')
                    <p class="address-form__error-message">{{ $message }}</p>
                @enderror
            </div>
            <input class="address-form__btn" type="submit" value="更新する">
        </form>
    </div>
</div>
@endsection