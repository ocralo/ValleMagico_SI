<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     * Computes and returns the Dissabilities associated with de current Location instance/row
     * @return Array<LocationSkin>
     */
    public function skins(){
        return $this->hasMany('App\LocationSkin');
    }

    /**
     * Computes and returns the Mini game associated with de current Location instance/row
     * @return Array<miniGame>
     */
    public function minigames(){
        return $this->hasMany('App\miniGame');
    }
}
