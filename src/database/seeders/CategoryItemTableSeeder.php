<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryItemTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'category_id' => '1',
            'item_id' => '1',
        ];
        DB::table('category_item')->insert($param);

        $param = [
            'category_id' => '2',
            'item_id' => '2',
        ];
        DB::table('category_item')->insert($param);

        $param = [
            'category_id' => '3',
            'item_id' => '2',
        ];
        DB::table('category_item')->insert($param);

        $param = [
            'category_id' => '4',
            'item_id' => '3',
        ];
        DB::table('category_item')->insert($param);

        $param = [
            'category_id' => '5',
            'item_id' => '3',
        ];
        DB::table('category_item')->insert($param);

        $param = [
            'category_id' => '6',
            'item_id' => '4',
        ];
        DB::table('category_item')->insert($param);

        $param = [
            'category_id' => '7',
            'item_id' => '4',
        ];
        DB::table('category_item')->insert($param);

        $param = [
            'category_id' => '8',
            'item_id' => '4',
        ];
        DB::table('category_item')->insert($param);

        $param = [
            'category_id' => '9',
            'item_id' => '4',
        ];
        DB::table('category_item')->insert($param);

        $param = [
            'category_id' => '9',
            'item_id' => '5',
        ];
        DB::table('category_item')->insert($param);

        $param = [
            'category_id' => '10',
            'item_id' => '5',
        ];
        DB::table('category_item')->insert($param);

        $param = [
            'category_id' => '11',
            'item_id' => '5',
        ];
        DB::table('category_item')->insert($param);

        $param = [
            'category_id' => '12',
            'item_id' => '5',
        ];
        DB::table('category_item')->insert($param);

        $param = [
            'category_id' => '13',
            'item_id' => '5',
        ];
        DB::table('category_item')->insert($param);
    }
}
