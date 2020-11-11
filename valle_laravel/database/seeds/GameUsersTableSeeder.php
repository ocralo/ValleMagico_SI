<?php

use Illuminate\Database\Seeder;
use App\GameUser;

class GameUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $new_game_user = new GameUser();
        $new_game_user->first_name = 'Gobernación';
        $new_game_user->second_name = '';
        $new_game_user->first_surname = 'Cauca';
        $new_game_user->second_surname = 'Colombia';
        $new_game_user->username = 'GOBCAUCA1234';
        $new_game_user->headquarter_id = 218;
        $new_game_user->grade_id = 1;
        $new_game_user->map_skin_id = 100;
        $new_game_user->save();

        $new_game_user_ps = new GameUser();
        $new_game_user->first_name = 'PRUEBA';
        $new_game_user->second_name = '';
        $new_game_user->first_surname = 'PLAYSTORE';
        $new_game_user->second_surname = 'PLAYSTORE';
        $new_game_user->username = 'USUARIOPS';
        $new_game_user->headquarter_id = 218;
        $new_game_user->grade_id = 0;
        $new_game_user->map_skin_id = 100;
        $new_game_user->save();
    }
}
