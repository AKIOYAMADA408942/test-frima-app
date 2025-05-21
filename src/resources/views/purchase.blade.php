@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css')}}">
@endsection

@section('tittle')
<title>フリマアプリ 商品購入</title>
@endsection

@section('content')
<div class="purchase-top">
    <div class="form__wrapper">
        <div class="purchase-side_left">
            <div class="purchase-item__inner">
                <div class="purchase-item__image-inner">
                    <img class="purchase-item__image" src="{{ asset($item->img_path) }}">
                </div>
                <div class="purchase-item__info">
                    <p class="purchase-item__name">{{ $item->name }}</p>
                    <p class="purchase-item__price"> ¥&nbsp {{ number_format($item->price) }}</p>
                </div>
            </div>
            <div class="purchase-payment">
                <h2>支払い方法</h2>
                <div class="purchase-payment__inner">
                    <select class="purchase-payment__select" id="select-payment" name="select-payment">
                        <option disabled selected>選択してください</option>
                        <option>コンビニ支払い</option>
                        <option>カード支払い</option>
                    </select>
                </div>
                @error('payment_method')
                    <p class="payment-form__error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="purchase-delivery">
                <div class="purchase-delivery__link-inner">
                    <h2 class="purchase-delivery__heading">配送先</h2>
                    <a class="purchase-address__link" href="/purchase/address/{{ $item->id }}">変更する</a>
                </div>
                <div class="purchase-delivery__address-inner">
                    <table class="address-table">
                        <tr>
                            <th class="address-table__header">〒 &nbsp </th>
                            <td class="address-table__data">{{ $user->postal_code }}</td>
                            @error('postal_code')
                                <td class="purchase-form__error-message">{{ $message }}</td>
                            @enderror
                        </tr>
                        <tr>
                            <th class="address-table__header">住所:&nbsp</th>
                            <td class="address-table__data">{{ $user->address }}</td>
                            @error('address')
                                <td class="purchase-form__error-message">{{ $message }}</td>
                            @enderror
                        </tr>
                        <tr class="address-table__row">
                            <th class="address-table__header">建物名:&nbsp</th>
                            <td class="address-table__data">{{ $user->building }}</td>
                            @error('building')
                                <td class="purchase-form__error-message">{{ $message }}</td>
                            @enderror
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="purchase-side__right">
            <table class="purchase-side__table">
                <tr class="purchase__row">
                    <th class="purchase__header">商品代金</th>
                    <td class="purchase__data">¥ {{ number_format($item->price) }}</td>
                </tr>
                <tr class="purchase__row">
                    <th class="purchase__header">支払い方法</th>
                    <td class="purchase__data" id="confirm-payment"></td>
                </tr>
            </table>
            @if($errors->any())
                <p class="purchase-form__error-message">支払い方法もしくは配送先に不備があります。</p>
            @endif
            <form action="/purchase/{{ $item->id }}" method="post">
                @csrf
                <input type="hidden" name="item_id" value="{{ $item->id }}">
                <input type="hidden" name="payment_method" id="payment_method">
                <input type="hidden" name="postal_code" value="{{ $user->postal_code }}">
                <input type="hidden" name="address" value="{{ $user->address }}">
                <input type="hidden" name="building" value="{{ $user->building }}">
                <button class="purchase-form__btn" type="submit">支払いへ移動</button>
            </form>
        </div>
    </div>
</div>
<script>
    const paymentMethod = document.getElementById('select-payment');
    const confirmPayment = document.getElementById('confirm-payment');

    paymentMethod.addEventListener('change',function()
    {
        confirmPayment.textContent = paymentMethod.options[paymentMethod.selectedIndex].text;

        document.getElementById('payment_method').value = paymentMethod.options[paymentMethod.selectedIndex].text;
    });
</script>
@endsection