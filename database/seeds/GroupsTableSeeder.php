<?php

use Illuminate\Database\Seeder;

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
            'groups_name' => 'filter_group1',            
        ]);
        DB::table('groups')->insert([            
            'groups_name' => 'filter_group2',            
        ]);
    }
}
