<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\TradingChatMessage;

class TradingChatMessageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for($i=1;$i<3; $i++){
            TradingChatMessage::create([
                'purchase_id' => 1,
                'sender_id' => 3,
                'content' => $faker->text(25),
                'is_read' => 1,
                'created_at' => $faker->dateTimeBetween('2024-10-9','2025-10-7'),
            ]);
        }

        for($i=1;$i<3; $i++){
            TradingChatMessage::create([
                'purchase_id' => 1,
                'sender_id' => 1,
                'content' => $faker->text(25),
                'is_read' => 1,
                'created_at' => $faker->dateTimeBetween('2024-10-9','2025-10-7'),
            ]);
        }

        for($i=1;$i<4; $i++){
            TradingChatMessage::create([
                'purchase_id' => 1,
                'sender_id' => 3,
                'content' => $faker->text(25),
                'created_at' => $faker->dateTimeBetween('2025-10-8','2025-10-10'),
            ]);
        }

        for($i=1;$i<2; $i++){
            TradingChatMessage::create([
                'purchase_id' => 1,
                'sender_id' => 1,
                'content' => $faker->text(25),
                'created_at' => $faker->dateTimeBetween('2025-10-8','2025-10-10'),
            ]);
        }

        for($i=1;$i<3; $i++){
            TradingChatMessage::create([
                'purchase_id' => 2,
                'sender_id' => 3,
                'content' => $faker->text(25),
                'is_read' => 1,
                'created_at' => $faker->dateTimeBetween('2024-10-9','2025-10-7'),
            ]);
        }

        for($i=1;$i<3; $i++){
            TradingChatMessage::create([
                'purchase_id' => 2,
                'sender_id' => 1,
                'content' => $faker->text(25),
                'is_read' => 1,
                'created_at' => $faker->dateTimeBetween('2024-10-9','2025-10-7'),
            ]);
        }

        for($i=1;$i<3; $i++){
            TradingChatMessage::create([
                'purchase_id' => 2,
                'sender_id' => 3,
                'content' => $faker->text(25),
                'created_at' => $faker->dateTimeBetween('2025-10-8','2025-10-10'),
            ]);
        }

        for($i=1;$i<1; $i++){
            TradingChatMessage::create([
                'purchase_id' => 2,
                'sender_id' => 1,
                'content' => $faker->text(25),
                'created_at' => $faker->dateTimeBetween('2025-10-8','2025-10-10'),
            ]);
        }

        for($i=1;$i<3; $i++){
            TradingChatMessage::create([
                'purchase_id' => 3,
                'sender_id' => 3,
                'content' => $faker->text(25),
                'is_read' => 1,
                'created_at' => $faker->dateTimeBetween('2024-10-9','2025-10-7'),
            ]);
        }

        for($i=1;$i<3; $i++){
            TradingChatMessage::create([
                'purchase_id' => 3,
                'sender_id' => 1,
                'content' => $faker->text(25),
                'is_read' => 1,
                'created_at' => $faker->dateTimeBetween('2024-10-9','2025-10-7'),
            ]);
        }
    }
}
