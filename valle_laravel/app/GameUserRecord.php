<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameUserRecord extends Model
{
    protected $fillable = [
        'errors', 'repeated_guide', 'total_score', 'mini_game_id', 'game_user_id'
    ];
    /**
     * Computes and returns the Minigame associated with de current GameUserRecord instance/row
     * @return Minigame
     */
    public function minigame(){
        return $this->belongsTo('App\MiniGame','mini_game_id');
    }
}
