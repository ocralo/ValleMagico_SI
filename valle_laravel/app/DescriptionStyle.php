<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DescriptionStyle extends Model
{
    /**
     * Computes and returns the Style associated with de current Description instance/row
     * @return Style
     */
    public function style(){
        return $this->belongsTo('App\Style');
    }
}
