<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Purchase;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->query('page');
        $keyword = $request->keyword;

        //商品データを取得および商品名を検索
        if(Auth::check())
        {
            if($page === 'mylist')
            {
                // マイリストページ
                $items = Like::where('user_id', Auth::id());
                $items = $items->whereHas('item',function($query)
                    {
                        $query->where('user_id', '!=', Auth::id());
                    });

                if(!empty($keyword))
                {
                    $items = $items->whereHas('item',function($query) use($keyword)
                    {
                        $query->where('name','like','%'. $keyword . '%');
                    });
                }
                $items = $items->get();

            } else {
                //　おすすめページ
                $items = Item::where('user_id', '!=', Auth::id());

                if(!empty($keyword))
                {
                    session()->flash('keyword',$keyword);
                    $items = $items->where('name','like','%'. $keyword . '%');
                }
                $items = $items->get();
            }
        } else {
            // 未ログインユーザー
            if(!empty($keyword))
            {
                $items = Item::where('name','like','%'. $keyword . '%')->get();
            } else {
                $items = Item::select('id','name','img_path')->get();
            }
        }

        $purchases = Purchase::select('item_id')->get();
        
        return view('index',compact('items','purchases','page'),['keyword' => $keyword]);
    }

    public function show($item_id)
    {
        $item = Item::find($item_id);
        $categories = $item->categories;
        $comments_count = Comment::where('item_id',$item_id)->count();
        $likes_count = Like::where('item_id',$item_id)->count();
        $mylike = Like::where('item_id',$item_id)->where('user_id',Auth::id())->first();

        if($mylike)
        {
            $item['mylike'] = 'likes-number__add';
        } else {
            $item['mylike'] = 'likes-number';
        }

        $purchase = Purchase::where('item_id',$item_id)->select('item_id')->first();
        $comments = Comment::where('item_id', $item_id)->with('user:id,name,thumbnail_path')->get();
        
        return view('show',compact('item','categories','comments','purchase','likes_count','comments_count'));
    }

    public function comment(CommentRequest $request)
    {
        $item_id = $request->item_id;
        
        Comment::create([
            'item_id' => $item_id,
            'user_id' => Auth::id(),
            'content' => $request->content,
        ]);

        return redirect()->route('show',$item_id);
    }

    public function like(Request $request)
    {
        $item_id = $request->item_id;
        $like = Like::where('user_id',Auth::id())->where('item_id', $request->item_id)->first();
        
        if(!$like)
        {
            like::create(
                [
                    'user_id' => Auth::id(),
                    'item_id' => $item_id,
                ]
            );
        } else {
            like::destroy($like->id);
        }
        return redirect()->route('show',$item_id);
    }
}
