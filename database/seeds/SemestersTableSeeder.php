<?php

use Illuminate\Database\Seeder;

class SemestersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $semesters = ['1st' , '2nd' , '3rd'];

        foreach($semesters as $semester){

            DB::table('semesters')->insert([
                'session_id' => App\SchoolSession::where('session_name' , '2019/2020')->pluck('id')->first(),
                'semester_name' => $semester,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        }
    }
}
