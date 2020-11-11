<?php

use Illuminate\Database\Seeder;
use App\Subject;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subjects_array = ['matemáticas', 'inglés', 'lenguaje', 'competencias ciudadanas', 'sociales',
                            'naturales'];

        foreach ($subjects_array as $key => $element) {
            $new_subject = new Subject();
            $new_subject->name = $element;
            $new_subject->save();
        }
    }
}
