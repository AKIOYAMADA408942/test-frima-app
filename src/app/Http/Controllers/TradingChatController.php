<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Models\Purchase;
use App\Models\TradingChatMessage;
use App\Models\Review;
use App\Http\Requests\ChatRequest;
use App\Mail\CompletedDealMail;


class TradingChatController extends Controller
{
    public function chatForm($purchase_id)
    {
        $purchase = Purchase::find($purchase_id);
        $review = Review::where('reviewer_id',Auth::id())->where('purchase_id',$purchase_id)->first();
        $chats = TradingChatMessage::where('purchase_id',$purchase_id)->orderBy('created_at','asc')->get();

        //その他の取引を取得
        $complete_deal_ids = Review::where('reviewer_id',Auth::id())->get()->pluck('purchase_id')->toArray();
        $total_deal_ids = Purchase::whereHas('item',function($query){
                $query->where('user_id',Auth::id());
            })->orWhere('user_id',Auth::id())->pluck('id')->toArray();

        $current_deal_ids = array_diff($total_deal_ids,$complete_deal_ids);
        $new_deals = Purchase::whereIn('id',$current_deal_ids)
            ->whereHas('tradingChatMessages',function($query){
                $query->where('sender_id', '!=', Auth::id())->where('is_read',null);
            })
            ->orderByDesc(
                TradingChatMessage::select('created_at')->whereColumn('trading_chat_messages.purchase_id','purchases.id')->latest()->take(1)
            )
            ->get();

        $new_message_dealing_ids = Purchase::whereIn('id',$current_deal_ids)
                ->whereHas('tradingChatMessages',function($query){
                    $query->where('sender_id', '!=', Auth::id())->where('is_read',null);
                })->pluck('id')->toArray();;

        $new_records = null;
        if(isset($new_message_dealing_ids))
        {
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
            })->pluck('id')->toArray();

        $old_deal_ids = array_diff($current_deal_ids,$new_deal_ids);
        
        $old_deals = Purchase::whereIn('id',$old_deal_ids)
            ->orderByDesc(
                TradingChatMessage::select('created_at')->whereColumn('trading_chat_messages.purchase_id','purchases.id')->latest()->take(1)
            )
            ->get();
        
        //既読処理
        $chats_unread = TradingChatMessage::where('purchase_id',$purchase_id)->where('sender_id','!=',Auth::id())->where('is_read',null)->get();
        
        if(isset($chats_unread))
        {
            foreach($chats_unread as $chat){
                $message = TradingChatMessage::find($chat->id);
                $message->is_read = 1;
                $message->update();
            }
        }
        return view('trading-chat',compact('purchase','chats','new_deals','old_deals','new_records','review'));
    }

    public function postMessage(ChatRequest $request,$purchase_id)
    {
        $purchase = Purchase::find($purchase_id);
        $uri = 'chat' . '/' .$purchase_id;

        if(isset($purchase->transaction_completed_at))
        {
            return redirect($uri)->with('complete','取引完了していますのでメッセージは送れません。');
        }
        $message = TradingChatMessage::create([
            'purchase_id' => $purchase_id,
            'sender_id' => Auth::id(),
            'content' => $request->content,
        ]);

        //画像の保存
        $image = $request->file('image');

        if(isset($image))
        {
            $path = Storage::disk('public')->putFile('chat_image', $image);
            $image_path = '/storage' . '/' .$path;
            
            $message->chatting_image_path = $image_path;
            $message->update();
        }
        
        return redirect($uri);
    }

    public function editMessage(ChatRequest $request,$chat_id)
    {
        $chat = TradingChatMessage::find($chat_id);
        $chat->content = $request->content;
        $chat->update();
        $uri = 'chat' . '/' .$chat->purchase_id;
        
        return redirect($uri);
    }

    public function deleteMessage(Request $request, $purchase_id)
    {
        $message = TradingChatMessage::find($request->id);
        $message->delete();

        $uri = 'chat' . '/' .$purchase_id;

        return redirect($uri);
    }

    public function completeDeal(Request $request)
    {
        $purchase = Purchase::find($request->purchase_id);
        $uri = 'chat' . '/' .$purchase->id;
        
        if(empty($purchase->transaction_completed_at))
        {
            $mail = [
                'seller_name' => $purchase->item->user->name,
                'buyer_name' => $purchase->user->name,
                'item_name' => $purchase->item->name,
            ];

            Mail::to($purchase->item->user->email)->send(new CompletedDealMail($mail));

            $purchase->transaction_completed_at = Carbon::now();
            $purchase->update();
        }

        return redirect($uri)->with('review_role','buyer');
    }

    public function reviewUser(Request $request, $purchase_id)
    {
        $purchase = Purchase::find($purchase_id);

        if(!isset($request->score))
        {
            if($purchase->user_id == Auth::id())
            {
                session()->flash('review_role','buyer');
            }

            $uri = 'chat' . '/' .$purchase->id;
            return redirect($uri)->with('score','星をクリックして評価点をつけてください。');
        }

        Review::create([
            'purchase_id' => $purchase_id,
            'reviewer_id' => Auth::id(),
            'reviewee_id' => $request->reviewee_id,
            'score' => $request->score,
        ]);

        return redirect('/');
    }
}
