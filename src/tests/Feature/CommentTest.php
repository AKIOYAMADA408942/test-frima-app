<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Comment;

class CommentTest extends TestCase
{
    use DatabaseMigrations;
    /**
     *
     * 9 コメント送信機能
     * @return void
     */
    //ログイン済みのユーザーはコメントが送信できる
    public function test_add_comment()
    {
        $this->seed();
        $user = User::find(2);
        $item = Item::find(1);

        $response = $this->actingAs($user)->get('/item/1');
        $response->assertStatus(200);
        $response->assertViewHas('comments_count',0); //コメント数が0と確認

        $response = $this->post('/comment',[
            'item_id' => $item->id,
            'user_id' => $user->id,
            'content' => 'テストコメント',
        ]);
        $this->assertDatabaseHas('comments',[
            'user_id' => $user->id,
            'item_id' => $item->id,
            'content' => 'テストコメント',
        ]);
        $response->assertRedirect('/item/1');
        
        $response = $this->get('/item/1');
        $response->assertViewHas('comments_count',1); //コメント数が1に増加
        $response->assertSeeText($user->name); //コメント者がビューに表示される
        $response->assertSeeText('テストコメント'); //コメント内容がビューに表示される
    }
    //ログイン前のユーザーはコメントを送信できない
    public function test_guest_cant_comment()
    {
        $this->seed();
        $item = Item::find(1);

        $response = $this->post('/comment',[
            'item_id' => $item->id,
            'content' => 'テストコメント',
        ]);
        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('comments',[
            'item_id' => $item->id,
            'content' => 'テストコメント',
        ]);

    }
    //コメント入力されていない場合、バリデーションメッセージが表示される。
    public function test_comment_none_validate(){
        $this->seed();
        $user = User::find(2);
        $item = Item::find(1);

        $response = $this->actingAs($user)->get('/item/1');
        $response->assertStatus(200);

        $response = $this->post('comment',[
            'item_id' => $item->id,
            'user_id' => $user->id,
            'content' => '',
        ]);

        $response->assertRedirect('/item/1');
        $response->assertStatus(302);
        $response->assertInvalid(['content'=>'コメントを入力してください']);

        $this->get('/item/1')->assertSeeText('コメントを入力してください');
    }

    //コメントが256文字以上の場合、バリデーションメッセージが表示される。
    public function test_comment_character256_validate(){
        $this->seed();
        $user = User::find(2);
        $item = Item::find(1);

        $response = $this->actingAs($user)->get('/item/1');
        $response->assertStatus(200);

        $response = $this->post('comment',[
            'item_id' => $item->id,
            'user_id' => $user->id,
            'content' => Str::random(256),
        ]);

        $response->assertRedirect('/item/1');
        $response->assertStatus(302);
        $response->assertInvalid(['content'=>'コメントは最大255文字以内で入力してください']);

        $this->get('/item/1')->assertSeeText('コメントは最大255文字以内で入力してください');
    }
}
