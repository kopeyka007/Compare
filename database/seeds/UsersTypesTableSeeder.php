<?php

use Illuminate\Database\Seeder;

class UsersTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_types')->insert([            
            'id' => 1,
            'name' => 'superadministrator',            
        ]);
        DB::table('users_types')->insert([            
            'id' => 2,
            'name' => 'administrator',            
        ]);
        DB::table('users_types')->insert([
            'id' => 3,
            'name' => 'moderator',            
        ]);

    }
}
