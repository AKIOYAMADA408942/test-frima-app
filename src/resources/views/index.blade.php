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
        <a class="{{ $page === null ? 'tab-active' : 'tab' }}" href="{{ route('index') }}">おすすめ</a>
        <a class="{{ $page === 'mylist' ? 'tab-active' : 'tab' }}" href="{{ route('index',['page' => 'mylist','keyword' => $keyword]) }}">マイリスト</a>
    </div>
    <div class="item-wrapper">
    
    {{-- おすすめページ --}}

    @if($page === null)
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
                        @if($item->id === $purchase->item_id)
                            <span class="sold">Sold</span>
                        @endif
                    @endforeach
                    </p>
                </a>
            </div>
        @endforeach
    @endif

    {{-- マイページ --}}

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