<?php

use Illuminate\Database\Seeder;
use App\Grade;

class GradesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $grades_array = ['transición', 'primero', 'segundo', 'tercero', 'cuarto', 'quinto', 'sexto', 
                        'septimo', 'octavo', 'noveno', 'transición primero', 'segundo tercero', 
                        'cuarto quinto', 'sexto septimo', 'octavo noveno'];

        foreach ($grades_array as $key => $element) {
            $new_grade = new Grade();
            $new_grade->id = $key;
            $new_grade->name = $element;
            $new_grade->save();
        }
    }
}
