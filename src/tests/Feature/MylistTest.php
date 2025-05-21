<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Purchase;
use App\Models\Like;

class MylistTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *  5 マイリスト一覧取得
     * @return void
     */

    //いいねした商品だけが表示される
    public function test_mylist_get()
    {
        $this->seed();
        Like::create([
            'user_id' => 2,
            'item_id' => 1,
        ]);
        Like::create([
            'user_id' => 2,
            'item_id' => 3,
        ]);

        $user = User::find(2);
        $mylists = Like::where('user_id', 2)->get();
        $item_id = $mylists->pluck('item_id');
        $items = Item::whereNotIn('id',$item_id)->get(); //いいねしていない商品を取得

        $response = $this->actingAs($user)->get(route('index',['page' => 'mylist']));
        $response->assertStatus(200);
        //いいねした商品の表示
        foreach($mylists as $mylist){
            $response->assertSeeText($mylist->item->name);
            $response->assertSee($mylist->item->img_path);
        }
        //いいねしていない商品の非表示
        foreach($items as $item){
            $response->assertDontSeeText($item->name);
            $response->assertDontSee($item->img_path);
        }
    }

    //購入した商品は商品一覧画面にて「Sold」と表示される
    public function test_mylist_purchase(){
        $this->seed();
        Like::create([
            'user_id' => 2,
            'item_id' => 1,
        ]);
        Like::create([
            'user_id' => 2,
            'item_id' => 3,
        ]);
        Purchase::create([
            'user_id' => '2',
            'item_id' => '1',
            'payment_method' => 'カード払い',
            'building' => 'test_building',
            'address' => 'test_address',
            'postal_code' => '000-0000',
        ]);

        $user = User::find(2);
        $item = Item::find(1);
        $purchases = Purchase::select('item_id')->get();

        $response = $this->actingAs($user)->get(route('index',['page' => 'mylist']));
        $response->assertStatus(200);
        $response->assertViewHas('purchases',$purchases);
        $response->assertSeeTextInOrder([$item->name,'Sold']);
    }
    //自分が出品した商品は表示されない
    public function test_mylist_sell(){
        $this->seed();
        Like::create([
            'user_id' => 2,
            'item_id' => 1,
        ]);
        Like::create([
            'user_id' => 2,
            'item_id' => 3,
        ]);
        
        $user = User::find(2);
        $items = Item::where('user_id', $user->id)->get();

        $response = $this->actingAs($user)->get(route('index',['page' => 'mylist']));
        $response->assertStatus(200);
        foreach($items as $item){
            $response->assertDontSeeText($item->name);
            $response->assertDontSee($item->img_path);
        }
    }

    //未認証の場合は何も表示されない
    public function test_no_login(){
        $this->seed();
        Like::create([
            'user_id' => 2,
            'item_id' => 1,
        ]);
        Like::create([
            'user_id' => 2,
            'item_id' => 3,
        ]);
        
        $user = User::find(2);
        $mylists = Like::where('user_id', 2)->get();

        $response = $this->get(route('index',['page' => 'mylist']));
        $response->assertStatus(200);

        $response->assertViewHas('items', null);
        $response->assertDontSee('item-card');
    }
}
