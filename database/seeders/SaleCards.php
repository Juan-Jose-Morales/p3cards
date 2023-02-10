<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SaleCards extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('salecards')->insert([
        [
            'amount' => rand(1,100),
            'price' => rand(1,2000),
            'card_id' => 1,
            'user_id' => 1,
        ],
        [
            'amount' => rand(1,100),
            'price' => rand(1,2000),
            'card_id' => 2,
            'user_id' => 2,
        ],
        [
            'amount' => rand(1,100),
            'price' => rand(1,1500),
            'card_id' => 3,
            'user_id' => 2,
        ],

    ]);
    }
}
