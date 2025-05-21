@extends('layouts.auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify.css')}}">
@endsection

@section('tittle')
<title>認証メール確認</title>
@endsection

@section('content')
<p class="mail-description">登録していただいたメールアドレスに認証メールを送付しました。<br>メール認証を完了して下さい.</p>
<form class="form-resend"action = "{{ route('verification.send')}}" method ="post">
    @csrf
    <button class="resend__button" type="submit">再送する</button>
</form>
<p class="mail-annotation">※メールが届かない等の不具合がある場合、上記のボタンから再送信をお試し下さい。<br>メール認証されましたらこちらのページをお閉じ下さい</p>
@endsection