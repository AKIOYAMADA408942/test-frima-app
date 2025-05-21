<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;

class ListItemTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     * 4 商品一覧取得
     * @return void
     */
    // 全商品を取得できる
    public function test_item_index()
    {
        $this->seed();
        $items = Item::select('name','img_path')->get();

        $response = $this->get('/');
        $response->assertStatus(200);
        foreach($items as $item){
            $response->assertSeeText($item->name);
            $response->assertSee($item->img_path);
        }
    }

    // 購入済み商品は「Sold」と表示される
    public function test_item_purchase()
    {
        $this->seed();

        Purchase::create([
            'user_id' => '2',
            'item_id' => '1',
            'payment_method' => 'カード払い',
            'building' => 'test_building',
            'address' => 'test_address',
            'postal_code' => '000-0000',
        ]);

        $purchases = Purchase::select('item_id')->get();
        $item = Item::find(1);

        $response = $this->get('/');
        $response->assertViewHas('purchases',$purchases);
        $response->assertSeeTextInOrder([$item->name,'Sold']);
    }
    
    // 自分が出品した商品は何も表示されない。
    public function test_item_index_login()
    {
        $this->seed();
        $user = User::find(1);
        $items = Item::where('user_id', $user->id)->get();

        $response = $this->actingAs($user)->get(route('index'));

        $response->assertStatus(200);
        foreach($items as $item){
            $response->assertDontSeeText($item->name);
            $response->assertDontSee($item->img_path);
        }
    }
}
