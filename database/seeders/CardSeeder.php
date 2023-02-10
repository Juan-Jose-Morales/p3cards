<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Card;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cards')->insert([
            [
                'name' => 'Bola de fuego',
                'description' => 'Lanza una poderosa bola de fuego al enemigo',
            ],
            [
                'name' => 'Rayo',
                'description' => 'Lanza un poderosa rayo al enemigo',
            ],
            [
                'name' => 'Terremoto',
                'description' => 'Lanza una poderoso terremoto enemigo',
            ],
        ]);
    }
}
