<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationSkin extends Model
{
    /**
     * Computes and returns the Location associated with de current GameUser instance/row
     * @return Location
     */
    public function location(){
        return $this->belongsTo('App\Location');
    }
}
