<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class GameUser extends Model
{
    protected $table = 'game_users';

    protected $fillable = [
        'first_name', 'second_name', 'first_surname', 'second_surname', 'username', 'headquarter_id', 
        'grade_id', 'map_skin_id'
    ];
    /**
     * Computes and returns the latest Avatar associated with de current GameUser instance/row
     * @return Avatar
     */
    public function current_avatar(){
        return $this->belongsToMany('App\Avatar','avatar_changes')->latest();
    }
    /**
     * Computes and returns the list of all Avatars associated with de current GameUser instance/row
     * @return Array<Avatar>
     */
    public function avatar_changes(){
        return $this->belongsToMany('App\Avatar','avatar_changes');
    }
    /**
     * Computes and returns the Dissabilities associated with de current GameUser instance/row
     * @return Array<Dissability>
     */
    public function dissabilities(){
        return $this->BelongsToMany('App\Dissability');
    }
    /**
     * Computes and returns the MapSkin associated with de current GameUser instance/row
     * @return MapSkin
     */
    public function map_skin(){
        return $this->belongsTo('App\MapSkin');
    }
    /**
     * Computes and returns the GameUserRecord associated with de current GameUser instance/row
     * @return Array<GameUserRecord>
     */
    public function game_records(){
        return $this->HasMany('App\GameUserRecord');
    }
    /**
     * Computes and returns the latest GameUserRecord associated with de current GameUser instance/row
     * @return Array<GameUserRecord>
     */
    public function latest_game_records(){
        return $this->HasMany('App\GameUserRecord')->latest()->groupBy('mini_game_id');
    }
}
