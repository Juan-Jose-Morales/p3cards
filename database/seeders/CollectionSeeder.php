<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Card;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('collections')->insert([
            [
                'name' => 'Hechizo',
                'symbol' => '',
                'editiondate' => '2021-03-12',
            ],
            [
                'name' => 'ElectroAtaques',
                'symbol' => '',
                'editiondate' => '2021-02-10',
            ],
            [
                'name' => 'Impactantes',
                'symbol' => '',
                'editiondate' => '2021-01-11',
            ]
        ]);


    }
}
