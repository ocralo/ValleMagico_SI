<?php

use Illuminate\Database\Seeder;
use App\LocationSkin;

class LocationSkinsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $location_ids_array = [100, 100, 100, 100,
                                101, 101, 101, 101,
                                102, 102, 102, 102,
                                103, 103,
                                104, 104,
                                105, 105,
                                106, 106, 106, 106,
                                107, 107, 107, 107,
                                108, 108, 108, 108,
                                109,
                                110,
                                111, 111, 111, 111,
                                112, 112, 112, 112,
                                113, 113,
                                114, 114,
                                115, 115, 115, 115,
                                116, 116, 116, 116,
                                117];

        foreach ($location_ids_array as $key => $element) {
            if ($element == 109 || $element == 110 || $element == 117) {
                $key_ = 0;
            } else {
                $key_ = ($key > 0 && $element > $location_ids_array[$key - 1]) || !isset($key_) ? 1 : $key_ + 1;
            }
            $new_location_skin = new LocationSkin();
            $new_location_skin->location_id = $element;
            $new_location_skin->level = $key_;
            $new_location_skin->skin = $key_;
            $new_location_skin->save();
        }
    }
}
