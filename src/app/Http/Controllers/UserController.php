<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\Review;
use App\Models\TradingChatMessage;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    //
    public function edit()
    {
        $user = User::find(Auth::id(),['name','postal_code','thumbnail_path','address','building']);

        return view('profile',compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = User::find(Auth::id());

        if($request->file('thumbnail') != null)
        {
            $image = $request->file('thumbnail');
            $path = Storage::disk('public')->putFile('thumbnails',$image);
            $user->thumbnail_path = '/storage'.'/'.$path;
        }

        $user->name = $request->name;
        $user->postal_code = $request->postal_code;
        $user->address = $request->address;
        $user->building = $request->building;
        $user->update();

        return redirect('/');
    }

    public function mypage(Request $request)
    {
        if(session()->has('keyword'))
        {
            session()->forget('keyword');
        }
        
        $page = $request->query('page');
        $user = User::find(Auth::id(),['name','thumbnail_path']);

        $total_deal_ids = Purchase::whereHas('item',function($query){
                $query->where('user_id',Auth::id());
            })->orWhere('user_id',Auth::id())->pluck('id')->toArray();

        $new_message_dealing_ids = Purchase::whereIn('id',$total_deal_ids)
                ->whereHas('tradingChatMessages',function($query){
                    $query->where('sender_id', '!=', Auth::id())->where('is_read',null);
                })->pluck('id')->toArray();

        $counts = count($new_message_dealing_ids);

        $average_score = null;
        $reviews = Review::where('reviewee_id', Auth::id())->get();
        if($reviews->count() !== 0 )
        {
            $count_record = $reviews->count();
            $total_score = 0;
            foreach($reviews as $review){
                $total_score = $total_score + $review->score;
            }

            $average_score = round($total_score / $count_record);
        }

        //出品タブ
        if($page === null or $page === 'sell')
        {
            $page = 'sell';
            $items = Item::where('user_id', Auth::id())->get();
            $purchases = Purchase::select('item_id')->get();

            return view('mypage',compact('purchases','items','user','counts','average_score'),['page' => $page]);
        }
        //購入タブ
        if($page === 'buy')
        {
            $items = purchase::where('user_id', Auth::id())->with('item')->get();
            $purchases = Purchase::select('item_id')->get();

            return view('mypage',compact('purchases','items','user','counts','average_score'),['page' => $page]);
        }
        //取引中タブ
        if($page === 'deal')
        {
            $complete_deal_ids = Review::where('reviewer_id',Auth::id())->get()->pluck('purchase_id')->toArray();
            $current_deal_ids = array_diff($total_deal_ids,$complete_deal_ids);

            $new_deals = Purchase::whereIn('id', $current_deal_ids)
                ->whereHas('tradingChatMessages',function($query){
                    $query->where('sender_id', '!=', Auth::id())->where('is_read',null);
                })
                ->orderByDesc(
                    TradingChatMessage::select('created_at')->whereColumn('trading_chat_messages.purchase_id','purchases.id')->latest()->take(1)
                )
                ->get();

            $new_records = null;
            if(isset($new_message_dealing_ids)){

                foreach($new_message_dealing_ids as $id)
                {
                    $new_message_count = TradingChatMessage::where('purchase_id',$id)->where('sender_id','!=',Auth::id())->where('is_read',null)->count();
                    $new_records[] = [
                        'purchase_id' => $id,
                        'count' => $new_message_count,
                    ];
                }
            }

            $new_deal_ids = Purchase::whereIn('id',$current_deal_ids)
                ->whereHas('tradingChatMessages',function($query){
                    $query->where('sender_id', '!=', Auth::id())->where('is_read',null);
                })->pluck('id')->toArray();;

            $old_deal_ids = array_diff($current_deal_ids, $new_deal_ids);
            
            $old_deals = Purchase::whereIn('id',$old_deal_ids)
                ->orderByDesc(
                    TradingChatMessage::select('created_at')->whereColumn('trading_chat_messages.purchase_id','purchases.id')->latest()->take(1)
                )
                ->get();

            return view('mypage-deal',compact('user','counts','new_deals','old_deals','new_records','average_score'),['page' => $page]);
        }
    }
}
