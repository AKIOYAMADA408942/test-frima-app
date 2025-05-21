@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/success.css')}}">
@endsection

@section('tittle')
<title>フリマアプリ 出品</title>
@endsection

@section('content')
    <div class="success__content">
        <h2 class="success__heading">支払い手続きは完了しました</h2>
        <a class="home__button-submit" href="/">商品一覧へ戻る</a>
    </div>
@endsection