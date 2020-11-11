<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MapSkin extends Model
{
    /**
     * Computes and returns the LocationSkin associated with de current GameUser instance/row
     * @return Array<LocationSkin>
     */
    public function location_skins(){
        return $this->belongsToMany('App\LocationSkin')->distinct();
    }
}
