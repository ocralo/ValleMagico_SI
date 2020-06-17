<?php

use Illuminate\Database\Seeder;
use App\DissabilityGameUser;

class DissabilityGameUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $init_id = 10000;
        $quantity_game_users = 1000;

        for ($i=0; $i < $quantity_game_users + 1 ; $i++) {
            $game_user_id = $i + $init_id;
            $new_insert = new DissabilityGameUser();
            $new_insert->game_user_id = $game_user_id;
            $new_insert->dissability_id = 1;
            $new_insert->save();
        }
    }
}
