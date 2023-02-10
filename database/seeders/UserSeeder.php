<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Validator;
use App\Http\Helpers\ResponseGenerator;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('users')->insert([
            [
                'name' => 'Andrea',
                'email' => 'Andrea@gmail.com',
                'password' => Hash::make('Andrea123456'),
                'role' => 'particular',
            ],
            [
                'name' => 'Cristina',
                'email' => 'Cristina@gmail.com',
                'password' => Hash::make('Cristina123456'),
                'role' => 'professional',
            ],
            [
                'name' => 'Eva',
                'email' => 'Eva@gmail.com',
                'password' => Hash::make('Eva123456'),
                'role' => 'admin',
            ]
        ]);

    }
}
