<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IntelligenceIndicator extends Model
{
    /**
     * Computes and returns the Intelligence associated with de current Indicator instance/row
     * @return Intelligence
     */
    public function intelligence(){
        return $this->belongsTo('App\Intelligence');
    }
}
