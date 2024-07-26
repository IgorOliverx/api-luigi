<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        DB::table('users')->insert([
            'id' => '1',
            'name' => 'igor',
            "email" => 'i@g.com',
            'password' => Hash::make('password'),
            ]);
     //   User::factory(50)->create();
    }
}
