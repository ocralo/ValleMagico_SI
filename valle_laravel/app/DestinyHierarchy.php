<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DestinyHierarchy extends Model
{
    /**
     * Computes and returns the Role associated with de current Destiny Hierarchy instance/row
     * @return Array<Role>
     */
    public function descriptions(){
        return $this->hasMany('App\Role');
    }
}
