<?php

use Illuminate\Database\Seeder;
use App\Avatar;

class AvatarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profession_array = $this->fillArray(array(), 0, 17);
        $gender_array = $this->fillArray(array(), 0, 1);
        $skin_array = $this->fillArray(array(), 0, 4);
        $age_array = $this->fillArray(array(), 0, 1);

        foreach ($profession_array as $key => $pro) {
            foreach ($gender_array as $key => $gen) {
                foreach ($skin_array as $key => $skin) {
                    foreach ($age_array as $key => $age) {
                        $new_avatar = new Avatar();
                        $new_avatar->profession = $pro;
                        $new_avatar->gender = $gen;
                        $new_avatar->skin = $skin;
                        $new_avatar->age = $age;
                        $new_avatar->save();
                    }
                }
            }
        }
    }

    protected function fillArray($array, $init, $end) {
        for ($i=$init; $i<=$end ; $i++) { 
            array_push($array, $i);
        }
        return $array;
    }
}
