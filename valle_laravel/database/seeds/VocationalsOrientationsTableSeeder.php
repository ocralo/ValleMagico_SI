<?php

use Illuminate\Database\Seeder;
use App\VocationalOrientation;

class VocationalsOrientationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $info_array = ['áreas contables y administrativas', 'áreas humanísticas y sociales',
                        'áreas artísticas', 'áreas de salud y medicina',
                        'áreas de ingeniería y computación', 'áreas de defensa y seguridad',
                        'áreas de ciencias exactas y agrícolas'];

        foreach ($info_array as $key => $element) {
            $new_insertion = new VocationalOrientation();
            $new_insertion->name = $element;
            $new_insertion->save();
        }
    }
}
