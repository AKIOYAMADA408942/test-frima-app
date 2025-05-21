<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;



class SellTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *  15 出品商品情報登録
     * @return void
     */
    //商品出品画面にて必要な情報が保存できること
    public function test_sell()
    {
        $this->seed();
        Storage::fake('public');
        $image = UploadedFile::fake()->create('test.jpg')->size(200);
        $categories = [1,3,5];
        $user = User::find(2);

        $response = $this->actingAs($user)->get('/sell');
        $response->assertStatus(200);
        $response = $this->post('/sell',[
            'image'=> $image,
            'categories' => $categories,
            'condition' => '良好',
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'content' => 'テスト商品説明',
            'price' => '1234567',
        ]);
        //itemテーブルの確認
        $this->assertDatabaseHas('items',[
            'user_id' => 2,
            'condition' => '良好',
            'name' => 'テスト商品',
            'brand' => 'テストブランド',
            'content' => 'テスト商品説明',
            'price' => '1234567',
            'img_path' => 'storage/' . 'item_image/' .$image->hashName(),
        ]);
        //itemテーブルの最新のデータを取得
        $item = Item::latest('id')->first();
        //category_itemテーブルの確認
        foreach($categories as $category){
            $this->assertDatabaseHas('category_item',[
                'category_id' => $category,
                'item_id' => $item->id,
            ]);
        }
        //画像ファイルの保存の確認
        Storage::disk('public')->assertExists('item_image/' .$image->hashName());
    }
}
