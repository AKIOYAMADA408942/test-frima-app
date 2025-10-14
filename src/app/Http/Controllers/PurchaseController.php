<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase;
use App\Models\Item;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Exception;

class PurchaseController extends Controller
{
    public function purchaseForm(Request $request,$item_id)
    {

        if(Purchase::where('item_id',$item_id)->exists())
        {
            return redirect()->route('show',$item_id)->with('sold','既に購入されております。');
        }

        $item = Item::find($item_id);
        $user = Auth::user();
        return view('purchase',compact('item','user'));
    }

    public function addressForm($item_id)
    {
        $user = Auth::user();

        return view('address',compact('user'),['item_id' => $item_id]);
    }

    public function addressEdit(AddressRequest $request,$item_id)
    {
        $user = Auth::user();

        $user->update([
            'postal_code' => $request->postal_code,
            'address' => $request->address,
            'building' => $request->building,
        ]);

        return redirect()->route('purchase.form',$item_id);
    }


    public function store(PurchaseRequest $request)
    {
        $item = Item::find($request->item_id);
        $purchase = Purchase::where('item_id',$request->item_id)->first();

        if($purchase)
        {
            return back()->withError('売り切れました。');
        }

        switch($request->payment_method)
        {
            case 'コンビニ支払い':
                $payment_method = 'konbini';
                break;
            case 'カード支払い':
                $payment_method = 'card';
        }

        session()->put(['payment_method' => $request->payment_method,]);

        try
        {
            //stripe決済セッション作成および画面遷移
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $session = Session::create([
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' =>['name' => $item->name,],
                        'unit_amount' => $item->price,
                    ],
                    'quantity' => 1,
                ]],
                'payment_method_types' => [ $payment_method ],
                'mode' => 'payment',
                'success_url' => route('purchase.success',['item_id' => $item->id]),
                'cancel_url' => route('purchase.form', ['item_id' => $item->id]),
            ]);

            return redirect($session->url);

        } catch(Exception $e) {
            return redirect()->back()->withErrors('エラーが発生しました');
        }
    }

    public function success(Request $request, $item_id)
    {
        if(Purchase::where('item_id',$item_id)->exists())
        {
            return back()->withError('sold','既に購入されております。');
        }

        Purchase::create([
            'user_id' => Auth::id(),
            'item_id' => $item_id,
            'payment_method' => session('payment_method'),
            'postal_code' => Auth::user()->postal_code,
            'address' => Auth::user()->address,
            'building' => Auth::user()->building,
        ]);

        session()->forget('payment_method');
        
        return view('purchase-success');
    }
}
