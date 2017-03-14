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
            'name' => 'superadministrator',            
        ]);
        DB::table('users_types')->insert([            
            'name' => 'administrator',            
        ]);
        DB::table('users_types')->insert([
            'name' => 'moderator',            
        ]);

    }
}
