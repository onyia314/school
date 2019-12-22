<?php

use Illuminate\Database\Seeder;

class SchoolClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $class_names = ['ss1' , 'ss2' , 'ss3'];
        $class_groups = ['science' , 'art'];

        foreach($class_names as $name){
            foreach($class_groups as $group){
                DB::table('classes')->insert([
                    'class_name' => $name,
                    'group' => $group,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
