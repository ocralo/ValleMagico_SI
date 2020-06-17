<?php

use Illuminate\Database\Seeder;
use App\Style;

class StylesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $styles_array = ['acomodadores', 'asimiladores', 'convergentes', 'divergentes'];
        $extra_names_array = ['combina la experiencia concreta y la experimentación activa',
                            'combina la conceptualización abstracta y la observación reflexiva',
                            'combina la conceptualización abstracta y la experimentación activa',
                            'combina la experiencia concreta y la observación reflexiva'];

        foreach ($styles_array as $key => $element) {
            $new_style = new Style();
            $new_style->name = $element;
            $new_style->description = $extra_names_array[$key];
            $new_style->save();
        }
    }
}
