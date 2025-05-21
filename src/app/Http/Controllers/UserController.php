<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
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

        if($page === null or $page === 'sell')
        {
            $page = 'sell';
            $items = Item::where('user_id', Auth::id())->get();
            $purchases = Purchase::select('item_id')->get();

        } elseif($page === 'buy') {
            $items = purchase::where('user_id', Auth::id())->with('item')->get();
            $purchases = Purchase::select('item_id')->get();
        }

        return view('mypage',compact('purchases','items','user',),['page' => $page]);
    }
}
