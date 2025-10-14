<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class PurchaseTest extends TestCase
{
     use DatabaseMigrations;
    /**
     * 10 商品購入機能
     *
     * @return void
     */
    //「購入する」ボタンを押下すると購入が完了する
    public function test_click_purchase_button()
    {
        $this->seed();
        $user = User::find(2);
        $user->postal_code = '000-0000';
        $user->address = 'テスト県テスト市テスト町';
        $user->building = 'テストビル1';
        $user->update();

        $response = $this->actingAs($user)->get('/purchase/1'); //item_id = 1
        $response->assertStatus(200);
        
        //purchaseテーブルに存在しないことを確認
        $this->assertDatabaseMissing('purchases',[
            'item_id' => 1,
            'user_id' => 2,
            'payment_method' => 'コンビニ支払い',
            'postal_code' => $user->postal_code,
            'address' => $user->address,
            'building' => $user->building,
        ]);
        
        //購入するボタンを押す
        $response = $this->post('/purchase/1',[
            'item_id' => 1,
            'payment_method' => 'コンビニ支払い',
            'postal_code' => $user->postal_code,
            'address' => $user->address,
            'building' => $user->building,
        ]);

        $response->assertStatus(302); //stripe決済画面にリダイレクトしたとする

        //stripe決済が完了し,購入完了画面へ遷移
        $response = $this->get('/purchase/1/success');
        $response->assertStatus(200);

        //purchaseテーブルに保存されているか確認
        $this->assertDatabaseHas('purchases',[
            'item_id' => 1,
            'user_id' => 2,
            'payment_method' => 'コンビニ支払い',
            'postal_code' => $user->postal_code,
            'address' => $user->address,
            'building' => $user->building,
        ]);
    }

    //購入した商品は商品画面一覧にて「sold」と表示される。
    public function test_purchased_item_display_as_sold_item_list()
    {
        $this->seed();
        $user = User::find(2);
        $user->postal_code = '000-0000';
        $user->address = 'テスト県テスト市テスト町';
        $user->building = 'テストビル1';
        $user->update();

        //商品一覧画面にて購入商品がないことを確認
        $response = $this->actingAs($user)->get('/');
        $response->assertStatus(200);
        $response->assertDontSeeText('Sold');

        //購入するボタンを押す
        $response = $this->post('/purchase/1',[
            'item_id' => 1,
            'payment_method' => 'コンビニ支払い',
            'postal_code' => $user->postal_code,
            'address' => $user->address,
            'building' => $user->building,
        ]);

        $response->assertStatus(302); //stripe決済画面にリダイレクトしたとする

        //stripe決済が完了し,購入完了画面へ遷移
        $response = $this->get('/purchase/1/success');
        $response->assertStatus(200);

        //商品一覧画面にて購入した腕時計がsoldと表示されている
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSeeTextInOrder(['腕時計','Sold']); //購入したitem_id =1は腕時計
    }

    //「プロフィール/購入した商品一覧」に追加されている。
    public function test_add_profile_purchased_item_list()
    {
        $this->seed();
        $user = User::find(2);
        $user->postal_code = '000-0000';
        $user->address = 'テスト県テスト市テスト町';
        $user->building = 'テストビル1';
        $user->update();

        //プロフィール画面の購入部品欄にて未購入の腕時計がないことを確認
        $response = $this->actingAs($user)->get('/mypage?page=buy');
        $response->assertStatus(200);
        $response->assertDontSeeText('腕時計');

        //購入するボタンを押す
        $response = $this->post('/purchase/1',[
            'item_id' => 1,
            'payment_method' => 'コンビニ支払い',
            'postal_code' => $user->postal_code,
            'address' => $user->address,
            'building' => $user->building,
        ]);

        $response->assertStatus(302); //stripe決済画面にリダイレクトしたとする

        //stripe決済が完了し,購入完了画面へ遷移
        $response = $this->get('/purchase/1/success');
        $response->assertStatus(200);

        //プロフィール画面の購入部品欄にて腕時計が追加されたことを確認
        $response = $this->get('/mypage?page=buy');
        $response->assertStatus(200);
        $response->assertSeeTextInOrder(['腕時計','Sold']); //購入したitem_id =1は腕時計
    }

}
