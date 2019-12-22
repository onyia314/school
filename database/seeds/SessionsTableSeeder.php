<?php

use Illuminate\Database\Seeder;

class SessionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('sessions')->insert([
           'session_name' => '2019/2020',
           'created_at' => now(),
           'updated_at' => now(),
       ]);
    }
}
