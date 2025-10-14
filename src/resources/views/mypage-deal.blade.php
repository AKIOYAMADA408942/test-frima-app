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
                @if($user->thumbnail_path === null)
                    <img class="profile__image" src="{{ asset('img/default-profile.svg') }}">
                @else
                    <img class="profile__image" src="{{ $user->thumbnail_path }}">
                @endif
                <div class="score-wrapper">
                    <span class="profile__name">{{ $user->name }}</span>
                    @if(isset($average_score))
                    <div>
                        <span class="star5-score" data-rate="{{$average_score}}"></span>
                    </div>
                    @endif
                </div>
            </div>
            <a class="profile-edit__btn" href="/mypage/profile">プロフィール編集</a>
        </div>
        <div class="top-tabs">
            <a class="@if($page === 'sell') tab-active @else tab @endif" href="{{ route('mypage',['page' => 'sell' ])}}">出品した商品</a>
            <a class="@if($page === 'buy') tab-active @else tab @endif" href="{{ route('mypage',['page'=> 'buy'])}}">購入した商品</a>
            <a class="@if($page === 'deal') tab-active @else tab @endif" href="{{ route('mypage',['page' => 'deal'])}}">取引中の商品
                @if(isset($counts) && $counts != 0)
                    <span class="new-record">{{ $counts }}</span>
                @endif
            </a>
        </div>
    <div class="item-wrapper">
    @if($page === 'deal')
        @foreach($new_deals as $item)
            <div class="item-card">
                <a class="item-link" href="/chat/{{ $item->id }}">
                    @foreach($new_records as $record)
                        @if($item->id === $record['purchase_id'])
                            <p class="message-count">{{ $record['count'] }}</p>
                        @endif
                    @endforeach
                    <img class="item-img" src="{{ $item->item->img_path }}" alt="商品画像">
                    <p class="item__name">{{ $item->item->name }}</p>
                </a>
            </div>
        @endforeach

        @foreach($old_deals as $item)
            <div class="item-card">
                <a class="item-link" href="/chat/{{ $item->id }}">
                    <img class="item-img" src="{{ $item->item->img_path }}" alt="商品画像">
                    <p class="item__name">{{ $item->item->name }}</p>
                </a>
            </div>
        @endforeach
    @endif
</div>
@endsection