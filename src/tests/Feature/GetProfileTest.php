<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Purchase;
use App\Models\Item;

class GetProfileTest extends TestCase
{
     use DatabaseMigrations;
    /**
     *  13 ユーザー情報取得
     * @return void
     */
    //必要な情報が取得できる（プロフィール画像、ユーザー名、出品した商品一覧、購入した商品一覧）
    public function test_get_profile()
    {
        $this->seed();

        $user = User::find(2);

        purchase::create([
            'user_id' => $user->id,
            'item_id' => 1,
            'payment_method' => 'カード支払い',
            'building' => 'テストビル1',
            'address' => 'テスト県テスト市テスト町',
            'postal_code' => '000-0000'
        ]);

        $response = $this->actingAs($user)->get('/mypage');

        $response->assertStatus(200);

        //プロフィール画像、ユーザー名が表示されているか確認
        $response->assertSeeText($user->name);
        $response->assertSee(asset($user->img_path));

        //出品した商品一覧　user_id = 2のitem
        $response->assertSeeText('マイク');
        $response->assertSeeText('ショルダーバッグ');
        $response->assertSeeText('タンブラー');
        $response->assertSeeText('コーヒーミル');
        $response->assertSeeText('メイクセット');
        
        //購入した商品一覧
        $response = $this->get('/mypage?page=buy');
        $response->assertStatus(200);
        $response->assertSeeText('腕時計'); //item_id = 1 購入した腕時計を確認
        $response->assertDontSeeText('マイク'); //item_id = 2　出品した商品がないことを確認
    }
}
