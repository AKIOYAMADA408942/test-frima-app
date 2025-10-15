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
                @if(isset($counts) && $counts != 0 )
                    <span class="new-record">{{ $counts }}</span>
                @endif
            </a>
        </div>
    <div class="item-wrapper">
    @if($page === 'sell')
        @foreach($items as $item)
            <div class="item-card">
                <a class="item-link" href="/item/{{ $item->id }}">
                    @if($purchases->isEmpty())
                        <div class="img-wrapper">
                            <img class="item-img" src="{{ asset($item->img_path) }}" alt="商品画像">
                        </div>
                    @else
                        @foreach($purchases as $purchase)
                            @if($item->id === $purchase->item_id)
                                <div class="img-wrapper img-sold">
                                    <img class="item-img" src="{{ asset($item->img_path) }}" alt="商品画像">
                                </div>
                                @break
                            @elseif($loop->last && $item->id !== $purchase->id)
                                <div class="img-wrapper">
                                    <img class="item-img" src="{{ asset($item->img_path) }}" alt="商品画像">
                                </div>
                            @endif
                        @endforeach
                    @endif
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
                <a class="item-link" href="/item/{{ $item->item->id }}">
                    <div class="img-wrapper img-sold">
                        <img class="item-img" src="{{ asset($item->item->img_path) }}" alt="商品画像">
                    </div>
                    <p class="item__name">{{ $item->item->name }}
                        <span class="sold">Sold</span>
                    </p>
                </a>
            </div>
        @endforeach
    @endif
</div>
@endsection