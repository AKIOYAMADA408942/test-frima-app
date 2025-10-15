@extends('layouts.auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/trading-chat.css')}}">
@endsection

@section('tittle')
<title>取引チャット</title>
@endsection

@section('content')
<div class="deal-wrapper">

    {{--取引完了モーダル  購入者--}}
    @if(Session('review_role') === 'buyer' && $review === null)
    <div class="review-wrapper">
        <h2 class="review-heading">取引が完了しました。</h2>
        <p class="review-question">今回の取引相手はどうでしたか？</p>
        <form class="review-form" action="/deal/review/{{ $purchase->id }}" method="post">
            @csrf
            <input type="hidden" name="reviewee_id" value="{{ $purchase->item->user_id }}">
            <div class="score-wrapper">
                <input type="radio" class="score-radio" id="star5" name="score" value="5">
                <label for="star5" class="score-label">★</label>
                <input type="radio" class="score-radio" id="star4" name="score" value="4">
                <label for="star4" class="score-label">★</label>
                <input type="radio" class="score-radio" id="star3" name="score" value="3" >
                <label for="star3" class="score-label">★</label>
                <input type="radio" class="score-radio" id="star2" name="score" value="2">
                <label for="star2" class="score-label">★</label>
                <input type="radio" class="score-radio"   id="star1" name="score" value="1">
                <label for="star1" class="score-label">★</label>
            </div>
            <div class="button-wrapper">
                @if(Session('score') != null)
                    <span class="score-form__error-message">{{ Session('score') }}</span>
                @endif
                <button class="review-button">送信する</button>
            </div>
        </form>
    </div>
    @endif

    {{--取引完了モーダル  販売者--}}
    @if($purchase->user_id !== Auth::id())
        @if(isset($purchase->transaction_completed_at) && $review === null)
        <div class="review-wrapper">
            <h2 class="review-heading">取引が完了しました。</h2>
            <p class="review-question">今回の取引相手はどうでしたか？</p>
            <form class="review-form" action="/deal/review/{{ $purchase->id }}" method="post">
            @csrf
                <input type="hidden" name="reviewee_id" value="{{ $purchase->item->user_id }}">
                <div class="score-wrapper">
                    <input type="radio" class="score-radio" id="star5" name="score" value="5">
                    <label for="star5" class="score-label">★</label>
                    <input type="radio" class="score-radio" id="star4" name="score" value="4">
                    <label for="star4" class="score-label">★</label>
                    <input type="radio" class="score-radio" id="star3" name="score" value="3" >
                    <label for="star3" class="score-label">★</label>
                    <input type="radio" class="score-radio" id="star2" name="score" value="2">
                    <label for="star2" class="score-label">★</label>
                    <input type="radio" class="score-radio"   id="star1" name="score" value="1">
                    <label for="star1" class="score-label">★</label>
                </div>
                <div class="button-wrapper">
                    @if(Session('score') != null)
                        <span class="score-form__error-message">{{ Session('score') }}</span>
                    @endif
                    <button class="review-button">送信する</button>
                </div>
            </form>
        </div>
        @endif
    @endif

    {{-- サイドバー --}}
    <div class="sidebar">
        <p class="sidebar-heading">その他の取引</p>
            <ul class="deal-lists">
            @foreach($new_deals as $item)
                @if($item->id !== $purchase->id)
                <a class="deal-link" href="/chat/{{ $item->id }}">
                    <li class="deal-item">{{ $item->item->name }}
                        @foreach($new_records as $record)
                            @if($item->id === $record['purchase_id'])
                                <span class="message-count">新着{{ $record['count'] }}件</span>
                            @endif
                        @endforeach
                    </li>
                </a>
                @endif
            @endforeach

            @foreach($old_deals as $item)
                @if($item->id !== $purchase->id)
                <a class="deal-link" href="/chat/{{ $item->id }}">
                    <li class="deal-item">{{ $item->item->name }}</li>
                </a>
                @endif
            @endforeach
        </ul>
    </div>

    <div class="main-wrapper">
        <div class="profile-wrapper">
            @if($purchase->user_id == Auth::id())
            <div class="thumbnail-wrapper">
                @if($purchase->item->user->thumbnail_path === null)
                    <img class="thumbnail" src="{{ asset('img/default-profile.svg') }}">
                @else
                    <img class="thumbnail" src="{{ $purchase->item->user->thumbnail_path }}">
                @endif
            </div>
            <h2 class="profile-name">{{ $purchase->item->user->name }}さんとの取引画面</h2>
            @else
            <div class="thumbnail-wrapper">
                @if($purchase->user->thumbnail_path === null)
                    <img class="thumbnail" src="{{ asset('img/default-profile.svg') }}">
                @else
                    <img class="thumbnail" src="{{ $purchase->user->thumbnail_path }}">
                @endif
            </div>
            <h2 class="profile-name">{{ $purchase->user->name }}さんとの取引画面</h2>
            @endif
            @if($purchase->user_id === Auth::id())
            <form class="complete-form" action="/deal/complete"  method="post">
                @csrf
                <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
                <button class="complete-form__button">取引完了する</button>
            </form>
            @endif
        </div>
        <div class="item-wrapper">
            <div class="item-image__wrapper">
                <img class="item-image" src="{{ $purchase->item->img_path}}">
            </div>
            <div class="item-content__wrapper">
                <h2 class="item-name">{{ $purchase->item->name }}</h2>
                <h3 class="item-price">￥{{ number_format($purchase->item->price) }}</h3>
            </div>
        </div>
        <div class="chat-wrapper">
            {{--自分の投稿 --}}
            @foreach($chats as $chat)
                @if($chat->sender_id === Auth::id())
                <div class="own-chat__wrapper">
                    <div class="own-chat__inner">
                        <div class="own-profile__wrapper">
                            <p class="own-profile__name">{{ $chat->user->name }}</p>
                            <div class="own-thumbnail__wrapper">
                                @if($chat->user->thumbnail_path !== null)
                                    <img class="own-thumbnail" src="{{ $chat->user->thumbnail_path }}">
                                @else
                                    <img class="own-thumbnail" src="{{ asset('img/default-profile.svg') }}">
                                @endif
                            </div>
                        </div>
                        <div class="own-message__wrapper">
                            @if(isset($chat->chatting_image_path))
                            <div class="message-image__wrapper">
                                <img class="message-image" src="{{ $chat->chatting_image_path }}">
                            </div>
                            @endif
                            <p class="own-message">{{ $chat->content }}</p>
                        </div>
                        <div class="own-message__form">
                            <div>
                                <a href="#modal-edit{{ $chat->id }}" id="close-edit{{$chat->id}}" class="modal-open">編集</a>
                            </div>
                            <form action="/chat/delete/{{ $purchase->id}}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $chat->id }}">
                                <button class="form-delete__button">削除</button>
                            </form>
                        </div>
                        {{-- 編集モーダル --}}
                        <form class="form-edit" action="/chat/edit/{{ $chat->id }}" id="modal-edit{{ $chat->id }}" method="post">
                            @csrf
                            <input class="edit-input" type="text" name="content" value="{{$chat->content}}">
                            <div class="edit-button__wrapper">
                                <button class="edit-button">保存</button>
                                <a href="#close-edit{{$chat->id}}" class="modal-close">キャンセル</a>
                            </div>
                        </form>
                    </div>
                </div>

                @else
                {{--相手の投稿--}}
                <div class="partner-chat__wrapper">
                    <div class="partner-chat__inner">
                        <div class="partner-profile__wrapper">
                            <div class="partner-thumbnail__wrapper">
                                @if($chat->user->thumbnail_path !== null)
                                    <img class="thumbnail" src="{{ $chat->user->thumbnail_path }}">
                                @else
                                    <img class="thumbnail" src="{{ asset('img/default-profile.svg') }}">
                                @endif
                            </div>
                            <p class="partner-name">{{ $chat->user->name }}</p>
                        </div>
                        <div class="partner-message__wrapper">
                            @if(isset($chat->chatting_image_path))
                            <div class="message-image__wrapper">
                                <img class="message-image" src="{{ $chat->chatting_image_path }}">
                            </div>
                            @endif
                            <p class="partner-message">{{ $chat->content }}</p>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
        <div class="chat-form__wrapper">
            @error('content')
                <p class="chat-form__error-message">{{ $message }}</p>
            @enderror
            @error('image')
                <p class="chat-form__error-message">{{ $message }}</p>
            @enderror
            @if(Session('complete') != null)
            <p class="chat-form__error-message">{{ session('complete') }}</p>
            @endif
            <form id="chat-form" class="chat-form" action="/chat/message/{{ $purchase->id }}" method="post" enctype="multipart/form-data">
                @csrf
                <input id="message" class="content-input" type="text" name="content" value="">
                <input id="file-image" class="chat-image" type="file" name="image">
                <label class="image-label"for="file-image">画像を追加</label>
                <button class="chat-form__button">
                    <img class="button-image" src="{{ asset('img/chat-form-button.jpg') }}">
                </button>
            </form>
        </div>
    </div>
</div>
<script>
    const inputMessage = document.getElementById('message');
    const pageIdentifier = location.pathname;

    //ページ読み込み時、ローカルストレージに保存された値を復元
    document.addEventListener('DOMContentLoaded',() => {

        const savedMessage = localStorage.getItem(pageIdentifier);
        if(savedMessage != null){
            inputMessage.value = savedMessage;
        }
        console.log(inputMessage.value);

    });
    //入力欄が変更されたらローカルストレージに保存する
    inputMessage.addEventListener('input',() => {

        localStorage.setItem(pageIdentifier,inputMessage.value);
    });

    //ページ読み込み時、ローカルストレージに保存された値を復元
    document.addEventListener('DOMContentLoaded',() => {

        const savedMessage = localStorage.getItem(pageIdentifier);

        if(savedMessage.value != null){
            inputMessage.value = savedMessage;
        }
    });
    //フォームが送信されたらローカルストレージのデータを削除
    const chatForm = document.getElementById('chat-form');
    chatForm.addEventListener('submit',() =>{
        localStorage.removeItem(pageIdentifier);
    });
</script>
@endsection