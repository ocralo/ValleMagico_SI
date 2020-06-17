<?php

use Illuminate\Database\Seeder;
use App\DescriptionStyle;

class DescriptionStylesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $descriptions_array = ['acomodadores: les gustan nuevas experiencias, son arriesgados.',
                            'acomodadores: se adaptan a las circunstancias inmediatas.',
                            'asimiladores: habilidad para crear modelos teóricos.',
                            'asimiladores: razonamiento inductivo.',
                            'asimiladores: razonamiento inductivo – relacionan patrones de pensamiento.',
                            'convergentes: son buenos en la aplicación práctica de las ideas.',
                            'divergentes: se caracterizan por ser individuos con un trasfondo enlas artes y/o humanidades.',
                            'divergentes: pueden ver las situaciones desde diferentes perspectivas.'];

        $id_styles_array = [700, 700,
                            701, 701, 701,
                            702,
                            703, 703];

        foreach ($descriptions_array as $key => $element) {
            $new_description_style = new DescriptionStyle();
            $new_description_style->description = $element;
            $new_description_style->style_id = $id_styles_array[$key];
            $new_description_style->save();
        }
    }
}
