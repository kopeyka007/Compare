<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([            
            'groups_name' => 'filter_grouup1',            
        ]);
        DB::table('groups')->insert([            
            'groups_name' => 'filter_grouup2',            
        ]);
    }
}
