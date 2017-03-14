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
            'type_id' => 1,
            'email' => 'div-art@com',
            'password' => bcrypt('1234'),
        ]);
    }
}
