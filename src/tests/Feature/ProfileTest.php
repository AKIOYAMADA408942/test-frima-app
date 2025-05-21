<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class ProfileTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *  14 ユーザー情報変更
     * @return void
     */
    //変更項目が初期値として過去設定されていること
    public function test_get_profile()
    {
        $this->seed();

        User::find(2)->update([
            'name' => 'test4',
            'img_path' => 'test.img',
            'postal_code' => '000-0000',
            'address' => 'テスト県テスト市',
            'building' =>'テストアパート000号室',
        ]);
        $user = User::find(2);

        $response = $this->actingAs($user)->get('/mypage/profile');
        $response->assertStatus(200);

        //初期値があることを確認
        $response->assertSee($user->name);
        $response->assertSee(asset($user->img_path));
        $response->assertSee($user->postal_code);
        $response->assertSee($user->address);
        $response->assertSee($user->building);
    }
}
