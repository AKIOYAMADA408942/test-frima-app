<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Like;
use App\Models\Comment;

class DetailItemTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     * 7 商品詳細情報取得
     * @return void
     */

    //必要な商品情報が表示される
    public function test_detail_item()
    {
        $this->seed();
        $user = User::find(2);
        $item = Item::find(1);

        $user->update([
            'img_path' => 'test.img',
            'postal_code' => '000-0000',
            'address' => 'テスト県テスト市',
            'building' =>'テストアパート000号室',
        ]);

        Like::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $comment = Comment::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => 'テストコメント',
        ]);
        $categories = $item->categories;
        $comments_count = Comment::where('item_id',$item->id)->count();
        $likes_count = $likes_count = Like::where('item_id',$item->id)->count();

        $response = $this->get('/item/1');
        $response->assertStatus(200);

        //ビュー表示確認
        $response->assertSee(asset($item->img_path)); //商品画像パス
        $response->assertSeeText($item->name); //商品名
        $response->assertSeeText($item->brand); //ブランド名
        $response->assertSeeText(number_format($item->price)); //価格
        $response->assertSeeText($likes_count); //いいね数
        $response->assertSeeText($comments_count); //コメント数
        $response->assertSeeText($item->content); //商品説明
        $response->assertSeeText($item->condition); //商品状態
        //カテゴリー
        foreach($categories as $category){
            $response->assertSeeText($category->name);
        }
        $response->assertSeeText($comment->user->name); //コメントしたユーザー
        $response->assertSeeText($comment->content); //コメント内容
    }

    //複数選択されたカテゴリが表示される
    public function test_item_category(){
        $this->seed();
        //アイテムId=2には２つのカテゴリーが存在
        $item = Item::find(2);
        $categories = $item->categories;

        $response = $this->get('/item/2');
        $response->assertSeeTextInOrder($categories->pluck('name')->toArray());
    }

}
