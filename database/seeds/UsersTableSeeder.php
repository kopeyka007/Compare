<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'users_type' => 0,
            'email' => 'div-art@com.ua',
            'password' => bcrypt('1234'),
        ]);
    }
}
