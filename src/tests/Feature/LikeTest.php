<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;

class LikeTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     * 8 いいね機能
     * @return void
     */

    //いいねアイコンを押下することによって、いいねした商品として登録することができる
    public function test_likes_add()
    {
        $this->seed();
        $user = User::find(2);
        $item = Item::find(1);

        $response = $this->actingAs($user)->get('/item/1');
        $response->assertStatus(200);
        $response->assertViewHas('likes_count',0); //いいねカウント数が0と確認

        $response = $this->post('/like',[
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        $this->assertDatabaseHas('likes',[
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        $response->assertRedirect('/item/1');

        $response = $this->get('/item/1');
        $response->assertViewHas('likes_count',1); //いいねカウント数が1と増加を確認
    }

    // 追加済のアイコンは色が変化する
    public function test_likes_change_color()
    {
        $this->seed();
        $user = User::find(2);
        $item = Item::find(1);

        $response = $this->actingAs($user)->get('/item/1');
        $response->assertStatus(200);
        $response->assertViewHas('likes_count',0);

        // いいねカウント数のCSSの適用セレクタを確認(押下前:likes-number)
        $response->assertSee('likes-number');
        $response->assertDontSee('likes-number__add');

        $response = $this->post('/like',[
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        $response = $this->get('/item/1');
        $response->assertViewHas('likes_count',1);

        //いいねカウント数のCSSの適用セレクタを確認(押下前:likes-number__add)
        $response->assertSee('likes-number__add');
    }

    // 再度いいねアイコンを押下することによって、いいねを解除することができる。
     public function test_likes_destroy()
    {
        $this->seed();
        $user = User::find(2);
        $item = Item::find(1);
        $like = Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);


        $response = $this->actingAs($user)->get('/item/1');
        $response->assertStatus(200);
        $response->assertViewHas('likes_count',1); //いいねカウント数が1と確認
        $this->assertDatabaseHas('likes',[
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->post('/like',[
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        //テーブルのデータの削除を確認
        $this->assertDeleted($like);

        $response->assertRedirect('/item/1');
        $response = $this->get('/item/1');
        $response->assertViewHas('likes_count',0); //いいねカウント数が0と減少を確認
    }
}