<?php

use Illuminate\Database\Seeder;
use App\Location;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $locations_array = ['supermercado', 'granja', 'hospital', 'panadería', 'estadio', 'restaurante',
                            'museo', 'policía', 'bomberos', 'biblioteca', 'escuela', 'heladeria',
                            'tierradentro', 'parque', 'gobernación', 'zoologico', 'industria', 'caldas'];

        foreach ($locations_array as $key => $element) {
            $new_location = new Location();
            $new_location->name = $element;
            $new_location->save();
        }
    }
}
