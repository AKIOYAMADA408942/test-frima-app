<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class RegisterUserTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *　1 会員登録機能
     * @return void
     */

    //名前が入力されていない場合、バリデーションメッセージが表示される
    public function test_register_user_validate_name()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $response = $this->post('/register',[
            'name' => '',
            'email' => 'test4@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertStatus(302);

        $response->assertInvalid(['name'=>'お名前を入力してください']);
        $this->get('/register')->assertSeeText('お名前を入力してください');
    }

    //メールアドレスが入力されていない場合、バリデーションメッセージが表示される
    public function test_register_user_validate_email()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $response = $this->post('/register',[
            'name' => 'test4',
            'email' => '',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertStatus(302);
        $response->assertInvalid(['email'=>'メールアドレスを入力してください']);

        $this->get('/register')->assertSeeText('メールアドレスを入力してください');
    }
    //パスワードが入力されていない場合、バリデーションメッセージが表示される
    public function test_register_user_validate_password()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $response = $this->post('/register',[
            'name' => 'test4',
            'email' => 'test4@example.com',
            'password' => '',
            'password_confirmation' => 'password',
        ]);
        $response->assertStatus(302);
        $response->assertInvalid(['password'=>'パスワードを入力してください']);

        $this->get('/register')->assertSeeText('パスワードを入力してください');
    }

    //パスワードが7文字以下の場合、バリデーションメッセージが表示される
    public function test_register_user_validate_size_password()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $response = $this->post('/register',[
            'name' => 'test4',
            'email' => 'test4@example.com',
            'password' => 'passwor',
            'password_confirmation' => 'passwor',
        ]);
        $response->assertStatus(302);
        $response->assertInvalid(['password'=>'パスワードは8文字以上で入力してください']);

        $this->get('/register')->assertSeeText('パスワードは8文字以上で入力してください');
    }

    //パスワードが確認用パスワードと一致しない場合、バリデーションメッセージが表示される
    public function test_register_user_validate_confirm_password()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $response = $this->post('/register',[
            'name' => 'test4',
            'email' => 'test4@example.com',
            'password' => 'password',
            'password_confirmation' => 'drowssap',
        ]);
        $response->assertStatus(302);
        $response->assertInvalid(['password'=>'パスワードと一致しません']);

        $this->get('/register')->assertSeeText('パスワードと一致しません');
    }

    //全ての項目が入力されている場合、会員情報が登録され、プロフィール設定画面に遷移する。
    public function test_register_user()
    {
        $response = $this->get('/register');
        $response->assertStatus(200);

        $response = $this->post('/register',[
            'name' => 'test4',
            'email' => 'test4@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertDatabaseHas('users',[
            'name' => 'test4',
            'email' => 'test4@example.com',
        ]);

        $response->assertRedirect('/mypage/profile');
    }
}
