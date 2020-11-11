<?php

use Illuminate\Database\Seeder;
use App\Intelligence;

class IntelligencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $intelligences_array = ['interpersonal', 'intrapersonal', 'kinestésica - corporal', 
                                'lingüística-verbal', 'lógico-matemática', 'musical', 
                                'naturalista', 'visual-espacial'];

        foreach ($intelligences_array as $key => $element) {
            $new_intelligence = new Intelligence();
            $new_intelligence->name = $element;
            $new_intelligence->save();
        }
    }
}
