<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intelligence extends Model
{
    /**
     * Computes and returns the Indicators associated with de current Intelligence instance/row
     * @return Array<IntelligenceIndicator>
     */
    public function indicators(){
        return $this->hasMany('App\IntelligenceIndicator');
    }
}
