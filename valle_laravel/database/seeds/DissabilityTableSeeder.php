<?php

use Illuminate\Database\Seeder;
use App\Dissability;

class DissabilityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dissabilities_array = ['ninguna', 'visual', 'motora', 'auditiva', 'cognitiva', 'talentos'];

        foreach ($dissabilities_array as $key => $element) {
            $new_dissability = new Dissability();
            $new_dissability->name = $element;
            $new_dissability->save();
        }
    }
}
