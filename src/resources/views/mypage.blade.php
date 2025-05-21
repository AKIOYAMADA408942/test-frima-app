@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css')}}">
@endsection

@section('tittle')
<title>フリマアプリ プロフィール</title>
@endsection

@section('content')
<div class="profile-wrapper">
        <div class="profile__group">
            <div class="profile__image-inner">
                <img class="profile__image" src="{{ $user->thumbnail_path }}">
                <span class="profile__name">{{ $user->name }}</span>
            </div>
            <a class="profile-edit__btn" href="/mypage/profile">プロフィール編集</a>
        </div>
        <div class="top-tabs">
            <a class="@if($page === 'sell') tab-active @else tab @endif" href="{{ route('mypage',['page' => 'sell' ])}}">出品した商品</a>
            <a class="@if($page === 'buy') tab-active @else tab @endif" href="{{ route('mypage',['page'=> 'buy'])}}">購入した商品</a>
        </div>
    <div class="item-wrapper">
    @if($page === 'sell')
        @foreach($items as $item)
            <div class="item-card">
                <a class="item-link" href="/item/{{ $item->id }}">
                    <img class="item-img" src="{{ $item->img_path }}" alt="商品画像">
                    <p class="item__name">{{ $item->name }}
                    @foreach($purchases as $purchase)
                        @if($item->id == $purchase->item_id)
                            <span class="sold">Sold</span>
                        @endif
                    @endforeach
                    </p>
                </a>
            </div>
        @endforeach
    @endif

    @if($page === 'buy')
        @foreach($items as $item)
            <div class="item-card">
                <a class="item-link" href="/item/{{ $item->id }}">
                    <img class="item-img" src="{{ $item->item->img_path }}" alt="商品画像">
                    <p class="item__name">{{ $item->item->name }}
                    @foreach($purchases as $purchase)
                        @if($item->item->id == $purchase->item_id)
                            <span class="sold">Sold</span>
                        @endif
                    @endforeach
                    </p>
                </a>
            </div>
        @endforeach
    @endif
</div>
@endsection