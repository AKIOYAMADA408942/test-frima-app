<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'test1',
            'email' => 'test1@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'postal_code' => '000-0000',
            'address' => 'テスト県テスト市テスト町',
            'building' => 'テストビル',
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => 'test2',
            'email' => 'test2@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'postal_code' => '000-0000',
            'address' => 'テスト県テスト市テスト町',
            'building' => 'テストビル',
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => 'test3',
            'email' => 'test3@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'postal_code' => '000-0000',
            'address' => 'テスト県テスト市テスト町',
            'building' => 'テストビル',
        ];
        DB::table('users')->insert($param);

    }
}
