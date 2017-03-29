<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            's3_key' => '',
            's3_secret' => '',
            's3_region' => '',
            's3_bucket' => '',
            's3_prods_folder' =>'',
        ]);
    }
}
