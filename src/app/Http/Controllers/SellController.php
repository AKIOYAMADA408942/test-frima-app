<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Item;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class SellController extends Controller
{
    public function sellForm()
    {
        if(session()->has('keyword')){
            session()->forget('keyword');
        }
        
        $categories = Category::all();

        return view('sell', compact('categories'));
    }

    public function store(ExhibitionRequest $request,Item $item)
    {
        $image = $request->file('image');
        $path = Storage::disk('public')->putFile('item_image', $image);
        $image_path = 'storage' . '/' .$path;

        $item->fill(
            [
                'name' => $request->name,
                'user_id' => Auth::id(),
                'condition' => $request->condition,
                'brand' => $request->brand,
                'content' => $request->content,
                'price' => $request->price,
                'img_path' => $image_path,
            ]
        )->save();

        $item->categories()->sync($request->categories);

        return redirect('/');
    }
}
