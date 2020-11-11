<?php

use Illuminate\Database\Seeder;
use App\miniGame;

class MiniGamesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $game_ids_array = ['G0LG01', 'G0LG02', 'G0LG03', 'G0MT01','G0MT02','G0MT03', 'G0IG01', 'G0IG02',
                            'G0IG03', 'G0BL01', 'G1LG01', 'G1LG02', 'G1LG03', 'G1MT01', 'G1MT02',
                            'G1MT03', 'G1IG01', 'G1IG02', 'G1IG03', 'G1BL01', 'G2LG01', 'G2LG02',
                            'G2LG03', 'G2MT01', 'G2MT02', 'G2IG01', 'G2IG02', 'G2IG03', 'G2BL01',
                            'G3LG01', 'G3LG02', 'G3LG03', 'G3MT01', 'G3MT02', 'G3MT03', 'G3IG01',
                            'G3IG02', 'G3BL01', 'G3SC01_MT', 'G3SC01_LG', 'G4LG01', 'G4LG02', 'G4MT01',
                            'G4MT02', 'G4IG01', 'G4IG02', 'G4BL01', 'G5LG01', 'G5LG02', 'G5MT01',
                            'G5MT02', 'G5IG01', 'G5IG02', 'G5BL01', 'G5SC01_MT', 'G5SC01_LG',
                            'G5SC01_IG', 'G5SC01_CC', 'G6LG01', 'G6LG02', 'G6MT01', 'G6MT02', 'G6IG01',
                            'G6IG02', 'G6BL01', 'G7LG01', 'G7LG02', 'G7MT01', 'G7MT02', 'G7IG01',
                            'G7IG02', 'G7BL01', 'G8LG01', 'G8LG02', 'G8MT01', 'G8MT02', 'G8IG01',
                            'G8IG02', 'G8BL01', 'G9LG01', 'G9LG02', 'G9MT01', 'G9MT02', 'G9IG01',
                            'G9IG02', 'G9BL01', 'G9SC01_MT', 'G9SC01_LG', 'G9SC01_IG', 'G9SC01_CC',
                            'G0MT04', 'G0LG04', 'G1MT04', 'G1LG04', 'G2MT03', 'G2LG04', 'G3MT04',
                            'G3LG04', 'G4MT03', 'G4LG03', 'G5MT03', 'G5LG03', 'G6MT03', 'G6LG03',
                            'G7MT03', 'G7LG03', 'G8MT03', 'G8LG03', 'G9MT03', 'G9LG03', 'G2IG04',
                            'G3IG04', 'G4IG03', 'G5IG03', 'G6IG03', 'G7IG03', 'G8IG03', 'G9IG03',
                            'G0NT01', 'G1NT01', 'G2NT01', 'G2NT02', 'G3NT01', 'G3NT02', 'G3NT03',
                            'G4NT01', 'G4NT02', 'G4NT03', 'G5NT01', 'G5NT02', 'G5NT03', 'G6NT01',
                            'G6NT02', 'G6NT03', 'G7NT01', 'G7NT02', 'G7NT03', 'G8NT01', 'G8NT02',
                            'G8NT03', 'G9NT01', 'G9NT02', 'G9NT03', 'G0CS01', 'G1CS01', 'G2CS01',
                            'G2CS02', 'G3CS01', 'G3CS02', 'G3CS03', 'G4CS01', 'G4CS02', 'G4CS03',
                            'G5CS01', 'G5CS02', 'G5CS03', 'G6CS01', 'G6CS02', 'G6CS03', 'G7CS01',
                            'G7CS02', 'G7CS03', 'G8CS01', 'G8CS02', 'G8CS03', 'G9CS01', 'G9CS02',
                            'G9CS03', 'INTMUL01', 'INTMUL02', 'INTMUL03', 'INTMUL04', 'INTMUL05',
                            'INTMUL06', 'INTMUL07', 'INTMUL08', 'INTMUL09', 'INTMUL10', 'INTMUL11', 
                            'INTMUL12', 'INTMUL13', 'INTMUL14', 'INTMUL15', 'G0LSC01', 'G1LSC01', 
                            'G2LSC01', 'G3LSC01', 'G4LSC01', 'G5LSC01', 'G6LSC01', 'G7LSC01', 'G8LSC01', 
                            'G9LSC01', 'CIU101', 'CIU102', 'CIU103', 'CIU104', 'CIU105', 'CIU106', 
                            'CIU107', 'CIU108', 'CIU109', 'CIU110', 'CIU111'];
        
        $location_ids_array = [101, 101, 101, 100, 100, 100, 102, 102, 102, 109, 101, 101, 101, 100, 100,
                            100, 102, 102, 102, 109, 101, 101, 101, 100, 100, 102, 102, 102, 109, 101,
                            101, 101, 100, 100, 100, 102, 102, 109, 110, 110, 104, 104, 103, 103, 105,
                            105, 109, 104, 104, 103, 103, 105, 105, 109, 110, 110, 110, 110, 107, 107,
                            108, 108, 106, 106, 109, 107, 107, 108, 108, 106, 106, 109, 107, 107, 108,
                            108, 106, 106, 109, 107, 107, 108, 108, 106, 106, 109, 110, 110, 110, 110,
                            100, 101, 100, 101, 100, 101, 100, 101, 103, 104, 103, 104, 108, 107, 108, 
                            107, 108, 107, 108, 107, 102, 102, 105, 105, 106, 106, 106, 106, 111, 111, 
                            111, 111, 111, 111, 111, 113, 113, 113, 113, 113, 113, 115, 115, 115, 115, 
                            115, 115, 115, 115, 115, 115, 115, 115, 112, 112, 112, 112, 112, 112, 112, 
                            114, 114, 114, 114, 114, 114, 116, 116, 116, 116, 116, 116, 116, 116, 116,
                            116, 116, 116, null, null, null, null, null, null, null, null, null, null, 
                            null, null, null, null, null, 117, 117, 117, 117, 117, 117, 117, 117, 117, 
                            117, 100, 101, 102, 103, 104, 105, 106, 107, 108, 109, 110];
        
        $grades_id_array = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 2, 2, 2, 2, 2, 2, 
                            2, 2, 2, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 4, 4, 4, 4, 4, 4, 4, 5, 5, 5, 5, 5, 
                            5, 5, 5, 5, 5, 5, 6, 6, 6, 6, 6, 6, 6, 7, 7, 7, 7, 7, 7, 7, 8, 8, 8, 8, 8, 8, 
                            8, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 9, 0, 0, 1, 1, 2, 2, 3, 3, 4, 4, 5, 5, 6, 6, 
                            7, 7, 8, 8, 9, 9, 2, 3, 4, 5, 6, 7, 8, 9, 0, 1, 2, 2, 3, 3, 3, 4, 4, 4, 5, 5, 
                            5, 6, 6, 6, 7, 7, 7, 8, 8, 8, 9, 9, 9, 0, 1, 2, 2, 3, 3, 3, 4, 4, 4, 5, 5, 5, 
                            6, 6, 6, 7, 7, 7, 8, 8, 8, 9, 9, 9, null, null, null, null, null, null, null, 
                            null, null, null, null, null, null, null, null, 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 
                            null, null, null, null, null, null, null, null, null, null, null];

        foreach ($game_ids_array as $key => $element) {
            $new_mini_game = new miniGame();
            $new_mini_game->name = $element;
            $new_mini_game->id_code = $element;
            $new_mini_game->location_id = $location_ids_array[$key];
            $new_mini_game->grade_id = $grades_id_array[$key];
            $new_mini_game->save();
        }
    }
}
