<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    protected $fillable = ['name'];
    /**
     * Computes and returns the headquarters associated with de current Institution instance/row
     * @return Array<HeadQuarters>
     */
    public function headquarters(){
        return $this->hasMany('App\Headquarter');
    }
}
