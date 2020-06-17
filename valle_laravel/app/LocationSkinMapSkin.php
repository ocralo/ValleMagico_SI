<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationSkinMapSkin extends Model
{
    protected $fillable = [
        'map_skin_id', 'location_skin_id'
    ];

    protected $table = 'location_skin_map_skin';
}
