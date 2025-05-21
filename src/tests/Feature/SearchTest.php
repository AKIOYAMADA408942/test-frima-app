<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Like;

class SearchTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *  6 商品検索機能
     * @return void
     */ 

    //「商品名」で部分一致検索ができる
    public function test_search()
    {
        $this->seed();

        //検索名 "革"　でテスト　ダミーデータの "革靴" 1件該当する
        $searches = Item::where('name','like', '%革%' )->get();
        $items = Item::where('name','not like', '%革%' )->get();
        
        $response = $this->get(route('index',[
            'page' => '',
            'keyword' => '革'
        ]));
        $response->assertStatus(200);
        //検索したレコードの商品が表示されている
        foreach($searches as $search){
            $response->assertSeeText($search->name);
        }
        //検索していない商品が表示されていない
        foreach($items as $item){
            $response->assertDontSeeText($item->name);
        }
    }

    //検索状態がマイリストでも保持されている
    public function test_mylist_hold_keyword()
    {
        $this->seed();
        $user = User::find(2);
        $item = Item::find(1);
        //検索名 "革"　でテスト　ダミーデータの "革靴"(id=4) 1件該当する
        Like::create([
            'user_id' => 2,
            'item_id' => 4,
        ]);
        Like::create([
            'user_id' => 2,
            'item_id' => 1,
        ]);
        
        $response = $this->actingAs($user)->get(route('index',[
            'page' => '',
            'keyword' => '革'
        ]));
        $response->assertStatus(200);
        $response->assertSeeText('革');

        $response = $this->get(route('index',[
            'page' => 'mylist',
            'keyword' => '革'
        ]));
        $response->assertStatus(200);
        $response->assertSeeText('革');　
        $response->assertDontSeeText($item->name); //お気に入りにあるアイテム ID=1 腕時計
    }
}
