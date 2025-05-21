@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css')}}">
@endsection

@section('tittle')
<title>フリマアプリ 商品一覧</title>
@endsection

@section('content')
<div class="top-wrapper">
    <div class="top-tabs">
        <a class="@if($page === null) tab-active @else tab @endif" href="{{ route('index',[]) }}">おすすめ</a>
        <a class="@if($page === 'mylist') tab-active @else tab @endif" href="{{ route('index',['page' => 'mylist','keyword' => $keyword]) }}">マイリスト</a>
    </div>
    <div class="item-wrapper">
    @if($page === null)
        @foreach($items as $item)
            <div class="item-card">
                <a class="item-link" href="/item/{{ $item->id }}">
                    <img class="item-img" src="{{ asset($item->img_path) }}" alt="商品画像">
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
    @if($page === 'mylist')
        @if(Auth::check())
            @foreach($items as $item)
            <div class="item-card">
                <a class="item-link" href="/item/{{ $item->item->id }}">
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
        @else
        <h2 class="not-login"> マイリストを閲覧するにはログインしてください</h2>
        @endif
    @endif
    </div>
@endsection