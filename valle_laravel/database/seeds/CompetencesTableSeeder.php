<?php

use App\Competence;
use Illuminate\Database\Seeder;

class CompetencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $competence1 = new Competence();
        $competence1->name = 'lectura crítica';
        $competence1->save();

        $competence2 = new Competence();
        $competence2->name = 'razonamiento cuantitativo';
        $competence2->save();

        $competence3 = new Competence();
        $competence3->name = 'comunicación escrita';
        $competence3->save();
    }
}
