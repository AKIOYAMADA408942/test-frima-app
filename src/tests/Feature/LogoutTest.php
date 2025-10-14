<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LogoutTest extends TestCase
{
    use DatabaseMigrations;
    /**
     *  3 ログアウト機能
     * @return void
     */
    //ログアウトができる
    public function test_logout()
    {
         $user = User::create([
            'name' => 'test4',
            'email' => 'test4@example.com',
            'password' => Hash::make('password'),
        ]);

        $response = $this->actingAs($user);
        $this->assertAuthenticatedAs($user,);

        $response = $this->post('/logout');
        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
