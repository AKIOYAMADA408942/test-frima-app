@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css')}}">
@endsection

@section('tittle')
<title>フリマアプリ 商品詳細</title>
@endsection

@section('content')
@error('content')
    <p class="comment-form__error-top">コメントが送信できませんでした。コメント欄をご確認ください</p>
@enderror
@if(session('sold'))
    <p class="comment-form__error-top">{{ session('sold') }}</p>
@enderror
<div class="item-detail__container">
    <div class="item-image__container">
        <img class="item-image" src="{{ asset($item->img_path) }}" alt="商品画像">
    </div>
    <div class="item-information__container">
        <h2 class="item-name">{{  $item->name }}
        @if($purchase)
            <span class="item-sold">(Sold)</span>
        @endif
        </h2>
        <p class="item-brand">{{ $item->brand }}</p>
        <p class="item-price">¥
            <span class="item-price__number">{{ number_format($item->price) }}</span>
            (税込)
        </p>
        <div class="assessment-container">
            <div class="assessment-image__inner">
                <form class="likes__form" action="/like" method="post">
                    @csrf
                    <button class="likes__btn" type="submit" class="like-submit">
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        @if($item->mylike === 'likes-number__add')
                            <img class="likes__image" src="{{ asset('img/favorite-star.svg')}}" alt="星マーク">
                        @else
                            <img class="likes__image" src="{{ asset('img/non-favorite-star.svg')}}" alt="星マーク">
                        @endif
                        <span class="{{ $item->mylike }}">{{ $likes_count }}</span>
                    </button>
                </form>
                <div class="comment-image__inner">
                    <img src="{{ asset('img/comment.png')}}" class="comment-image" alt="コメント数アイコン">
                    <span class="comment-count">{{ $comments_count }}</span>
                </div>
            </div>
        </div>
        @if(!$purchase)
            <a class="purchase-btn" href="/purchase/{{ $item->id }}">購入手続きへ</a>
        @else
            <p class="purchase-sold">売り切れました</p>
        @endif
        <div>
            <h3 class="item-explain">商品説明</h3>
            <p class="item-explain__content">{{ $item->content }}</p>
        </div>
        <div class="item-information">
            <h3 class="item-information__heading">商品の情報</h3>
            <table class="item-information__table">
                <tr class="table-row__category">
                    <th class="table-header__category">カテゴリ</th>
                    @foreach($categories as $category)
                        <td class="table-data__category">{{ $category->name }}</td>
                    @endforeach
                </tr>
                <tr class="table-row__condition">
                    <th class="table-heading__condition">商品の状態</th>
                    <td class="table-data__condition"> {{ $item->condition }}</td>
                </tr>
            </table>
        </div>
        <div class="item-comment">
            <h3 class="item-comment__heading">コメント({{ $comments_count }})</h3>
            @foreach($comments as $comment)
                <div class="item-comment__inner-image">
                    @if($comment->user->thumbnail_path === null)
                        <img class="item-comment__image" src="{{ asset('img/default-profile.svg') }}">
                    @else
                        <img class="item-comment__image" src="{{ $comment->user->thumbnail_path }}" alt="コメントユーザー画像">
                    @endif
                    <p class="item-comment__name">{{ $comment->user->name }}</p>
                </div>
                <div class="item-comment__wrapper">
                    <p class="item-comment__content">{{ $comment->content }}</p>
                </div>
            @endforeach
            <form action="/comment" method="post">
                @csrf
                <h4 class="comment-form__heading">商品へのコメント</h4>
                <input type="hidden" name="item_id" value="{{ $item->id }}">
                <textarea class="comment-form__textarea" name="content">{{ old('content') }}</textarea>
                @error('content')
                    <p class="comment-form__error-message">{{ $message }}</p>
                @enderror
                <button class="comment-form__btn" type="submit">コメントを送信する</button>
            </form>
        </div>
    </div>
</div>
@endsection