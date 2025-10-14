<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginTest extends TestCase
{
    use DatabaseMigrations;
    /**
     *　2 ログイン機能
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::create([
            'name' => 'test4',
            'email' => 'test4@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
    }

    //メールアドレスが入力されていない場合、バリデーションメッセージが表示される
    public function test_login_varidate_mail()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);

        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertInvalid(['email'=>'メールアドレスを入力してください']);

        $this->get('/login')->assertSeeText('メールアドレスを入力してください');
    }
    
    //パスワードが入力されていない場合、バリデーションメッセージが表示される
    public function test_login_varidate_passsword()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);

        $response = $this->post('/login', [
            'email' => 'test4@example.com',
            'password' => '',
        ]);

        $response->assertStatus(302);
        $response->assertInvalid(['password'=>'パスワードを入力してください']);

        $this->get('/login')->assertSeeText('パスワードを入力してください');
    }

    //入力情報が間違っている場合、バリデーションメッセージが表示される
    public function test_login_infomation_dont_match()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);

        $response = $this->post('/login', [
            'email' => 'test4@example.com',
            'password' => 'test1234',
        ]);

        $response->assertStatus(302);
        $response->assertInvalid(['email'=>'ログイン情報が登録されていません']);

        $this->get('/login')->assertSeeText('ログイン情報が登録されていません');
    }
    //正しい情報が入力された場合、ログイン処理が実行される
    public function test_login(){
        $response = $this->get('/login');
        $response->assertStatus(200);

        $response = $this->post('/login', [
            'email' => 'test4@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('/');
        $this->assertAuthenticatedAs($this->user);
    }
}
