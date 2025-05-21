<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class AddressTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     *  12 配送先変更機能
     * @return void
     */

     //送付先の住所変更画面にて登録した住所が商品購入画面に反映されている
    public function test_adress_change()
    {
        $this->seed();
        User::find(2)->update([
            'img_path' => 'test.img',
            'postal_code' => '000-0000',
            'address' => 'テスト県テスト市',
            'building' =>'テストアパート000号室',
        ]);
        $user = User::find(2);
        
        //ユーザーにログインして現在の送付先を確認
        $response = $this->actingAs($user)->get('/purchase/1');
        $response->assertStatus(200);
        $response->assertSeeText('000-0000');
        $response->assertSeeText('テスト県テスト市');
        $response->assertSeeText('テストアパート000号室');

        //送付先住所を登録する
        $response = $this->post('/purchase/address/1',[
            'postal_code' => '012-3456',
            'address' => 'テスト変更県変更市',
            'building' => 'テスト変更アパート000号室',
        ]);
        $response->assertRedirect('/purchase/1');
        $this->assertDatabaseHas('users',[
            'postal_code' => '012-3456',
            'address' => 'テスト変更県変更市',
            'building' => 'テスト変更アパート000号室',
        ]);

        //送付先住所が変更されているのを確認
        $response = $this->get('/purchase/1');
        $response->assertSeeText('012-3456');
        $response->assertSeeText('テスト変更県変更市');
        $response->assertSeeText('テスト変更アパート000号室');
    }
}
