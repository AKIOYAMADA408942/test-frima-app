@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css')}}">
@endsection

@section('tittle')
<title>フリマアプリ 出品</title>
@endsection

@section('content')
<div class="sell-content">
    <h1 class="sell-content__heading">商品出品</h1>
    @if($errors->any())
        <p class="sell-form__error-message">入力箇所に問題があります。</p>
    @endif
    <div class="sell-form__inner">
        <form class="sell-form" action="/sell" method="post" enctype="multipart/form-data">
            @csrf
            <div class="sell-form__group">
                <p class="sell-form__description">商品画像</p>
                <div class="sell-form__image-inner">
                    <input class="sell-form__input-image" type="file" name="image" id="image">
                    <label class="sell-form__label-image" for="image" >画像を選択する</label>
                </div>
                @error('image')
                    <p class="sell-form__error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="sell-form__group">
                <h2 class="sell-form__subheading">商品の詳細</h2>
                <p class="sell-form__description">カテゴリー</p>
                <div class="sell-form__checkbox-inner">
                @foreach($categories as $category)
                    <input class="sell-form__checkbox" type="checkbox" name="categories[]" value="{{ $category->id}}" id="{{ $category->id }}"
                    @if($errors){{ is_array(old('categories')) && array_keys(old('categories'),$category->id)? 'checked' : '' }} @endif>
                    <label class="sell-form__checkbox-label" for="{{ $category->id }}">{{ $category->name }}</label>
                @endforeach
                @error('categories')
                    <p class="sell-form__error-message">{{ $message }}</p>
                @enderror
                </div>
                <p class="sell-form__label">商品の状態</p>
                <select class="sell-form__select" name="condition">
                    <option disabled selected style="display:none;">選択してください</option>
                    <option value="良好" {{ old('condition') === '良好'? 'selected' : '' }}>良好</option>
                    <option value="目立った傷や汚れなし" {{ old('condition') === '目立った傷や汚れなし' ? 'selected' : '' }}>目立った傷や汚れなし</option>
                    <option value="やや傷や汚れあり" {{ old('condition') === 'やや傷や汚れあり' ? 'selected' : '' }}>やや傷や汚れあり</option>
                    <option value="状態が悪い" {{ old('condition') === '状態が悪い' ? 'selected' : '' }}>状態が悪い</option>
                </select>
                @error('condition')
                    <p class="sell-form__error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="sell-form__group">
                <h2 class="sell-form__subheading">商品名と説明</h2>
                <label class="sell-form__label" for="name">商品名</label>
                <input class="sell-form__input" type="text" name="name" id="name" value="{{ old('name')}}">
                @error('name')
                    <p class="sell-form__error-message">{{ $message }}</p>
                @enderror
                <label class="sell-form__label" for="brand">ブランド名</label>
                <input class="sell-form__input" type="text" name="brand" id="brand" value="{{ old('brand')}}">
                <label class="sell-form__label-text" for="content">商品説明</label>
                <textarea class="sell-form__text" name="content" id="content">{{ old('content')}}</textarea>
                @error('content')
                    <p class="sell-form__error-message">{{ $message }}</p>
                @enderror
                <label class="sell-form__label" for="price">販売価格</label>
                <div  class="sell-form__price-inner">
                    <span class="sell-form__price-tag">¥</span>
                </div>
                <input class="sell-form__input-price" type="text" name="price" id="price" value="{{ old('price')}}">
                @error('price')
                    <p class="sell-form__error-message">{{ $message }}</p>
                @enderror
            </div>
            <input class="sell-form__btn" type="submit" value="出品する">
        </form>
    </div>
</div>
@endsection