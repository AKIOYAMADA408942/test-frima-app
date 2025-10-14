<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Purchase;

class PurchaseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Purchase::create([
            'user_id' => 3,
            'item_id' => 1,
            'payment_method' => 'カード支払い',
            'postal_code' => '000-0000',
            'address' => 'テスト県テスト市テスト町',
            'building' => 'テストビル',
        ]);

        Purchase::create([
            'user_id' => 3,
            'item_id' => 2,
            'payment_method' => 'カード支払い',
            'postal_code' => '000-0000',
            'address' => 'テスト県テスト市テスト町',
            'building' => 'テストビル',
        ]);

        Purchase::create([
            'user_id' => 3,
            'item_id' => 3,
            'payment_method' => 'カード支払い',
            'postal_code' => '000-0000',
            'address' => 'テスト県テスト市テスト町',
            'building' => 'テストビル',
        ]);

        Purchase::create([
            'user_id' => 2,
            'item_id' => 4,
            'payment_method' => 'カード支払い',
            'postal_code' => '000-0000',
            'address' => 'テスト県テスト市テスト町',
            'building' => 'テストビル',
        ]);

        Purchase::create([
            'user_id' => 2,
            'item_id' => 5,
            'payment_method' => 'カード支払い',
            'postal_code' => '000-0000',
            'address' => 'テスト県テスト市テスト町',
            'building' => 'テストビル',
        ]);

        Purchase::create([
            'user_id' => 3,
            'item_id' => 6,
            'payment_method' => 'カード支払い',
            'postal_code' => '000-0000',
            'address' => 'テスト県テスト市テスト町',
            'building' => 'テストビル',
        ]);

        Purchase::create([
            'user_id' => 3,
            'item_id' => 7,
            'payment_method' => 'カード支払い',
            'postal_code' => '000-0000',
            'address' => 'テスト県テスト市テスト町',
            'building' => 'テストビル',
        ]);

        Purchase::create([
            'user_id' => 1,
            'item_id' => 8,
            'payment_method' => 'カード支払い',
            'postal_code' => '000-0000',
            'address' => 'テスト県テスト市テスト町',
            'building' => 'テストビル',
        ]);

        Purchase::create([
            'user_id' => 1,
            'item_id' => 9,
            'payment_method' => 'カード支払い',
            'postal_code' => '000-0000',
            'address' => 'テスト県テスト市テスト町',
            'building' => 'テストビル',
        ]);
    }
}
