<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $param =[
            'user_id' => '1',
            'name' => '腕時計',
            'price' => '15000',
            'content' => 'スタイリッシュなデザインのメンズ腕時計',
            'img_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
            'condition' => '良好',
        ];
        DB::table('items')->insert($param);

        $param =[
            'user_id' => '1',
            'name' => 'HDD',
            'price' => '5000',
            'content' => '高速で信頼性の高いハードディスク',
            'img_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
            'condition' => '目立った傷や汚れなし',
        ];
        DB::table('items')->insert($param);

        $param =[
            'user_id' => '1',
            'name' => '玉ねぎ3束',
            'price' => '300',
            'content' => '新鮮な玉ねぎ3束のセット',
            'img_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
            'condition' => 'やや傷や汚れあり',
        ];
        DB::table('items')->insert($param);

        $param =[
            'user_id' => '1',
            'name' => '革靴',
            'price' => '4000',
            'content' => 'クラシックなデザインの革靴',
            'img_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
            'condition' => '状態が悪い',
        ];
        DB::table('items')->insert($param);

        $param =[
            'user_id' => '1',
            'name' => 'ノートPC',
            'price' => '45000',
            'content' => '高性能なノートパソコン',
            'img_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
            'condition' => '良好',
        ];
        DB::table('items')->insert($param);

        $param =[
            'user_id' => '2',
            'name' => 'マイク',
            'price' => '8000',
            'content' => '高音質のレコーディング用マイク',
            'img_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
            'condition' => '目立った傷や汚れなし',
        ];
        DB::table('items')->insert($param);

        $param =[
            'user_id' => '2',
            'name' => 'ショルダーバッグ',
            'price' => '3500',
            'content' => 'おしゃれなショルダーバッグ',
            'img_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
            'condition' => 'やや傷や汚れあり',
        ];
        DB::table('items')->insert($param);

        $param =[
            'user_id' => '2',
            'name' => 'タンブラー',
            'price' => '500',
            'content' => '使いやすいタンブラー',
            'img_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
            'condition' => '状態が悪い',
        ];
        DB::table('items')->insert($param);

        $param =[
            'user_id' => '2',
            'name' => 'コーヒーミル',
            'price' => '4000',
            'content' => '手動のコーヒーミル',
            'img_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
            'condition' => '良好',
        ];
        DB::table('items')->insert($param);

        $param =[
            'user_id' => '2',
            'name' => 'メイクセット',
            'price' => '2500',
            'content' => '便利なメイクアップセット',
            'img_path' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
            'condition' => '目立った傷や汚れなし',
        ];
        DB::table('items')->insert($param);
    }
}
