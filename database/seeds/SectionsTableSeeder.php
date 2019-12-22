<?php

use Illuminate\Database\Seeder;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $schoolClasses = App\SchoolClass::pluck('id')->toArray();
        $sections = ['A' , 'B' , 'C'];

        foreach($schoolClasses as $class_id){

            foreach($sections as $section_name){
                DB::table('sections')->insert([
                    'class_id' => $class_id,
                    'section_name' => $section_name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

        }

    }
}
