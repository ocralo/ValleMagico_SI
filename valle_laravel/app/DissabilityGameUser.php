<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DissabilityGameUser extends Model
{
    protected $table = 'dissability_game_user';

    protected $fillable = ['game_user_id', 'dissability_id'];
}
