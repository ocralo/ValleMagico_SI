<?php

use App\DestinyHierarchy;
use Illuminate\Database\Seeder;

class DestinyHierarchySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $destinies_array = ['departments', 'towns', 'institutions', 'headquarters', 'grades', 'students'];

        foreach ($destinies_array as $key => $element) {
            $destinyHierarchy = new DestinyHierarchy();
            $destinyHierarchy->table_name = $element;
            $destinyHierarchy->save();
        }
    }
}
