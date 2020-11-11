<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MiniGame extends Model
{
    /**
     * Computes and returns the Subject associated with de current mini game instance/row
     * @return Array<Subject>
     */
    public function subjects(){
        return $this->BelongsToMany('App\Subject');
    }

    /**
     * Computes and returns the Location associated with de current mini game instance/row
     * @return Array<Location>
     */
    public function locations(){
        return $this->belongsTo('App\Location');
    }
}
