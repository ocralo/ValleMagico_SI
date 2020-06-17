<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Town extends Model
{
    protected $fillable = ['name'];
    /**
     * Computes and returns the Headquarters associated with de current Town instance/row
     * @return Array<Headquarters>
     */
    public function headquarters(){
        return $this->hasMany('App\Headquarter');
    }
    /**
     * Computes and returns the TownType associated with de current Town instance/row
     * @return TownType
     */
    public function type(){
        return $this->belongsTo('App\TownType','town_type_id');
    }
    /**
     * Computes and returns the Department associated with de current Town instance/row
     * @return Department
     */
    public function department(){
        return $this->belongsTo('App\Department');
    }
    /**
     * Computes and returns the Zone associated with de current Town instance/row
     * @return Zone
     */
    public function zone(){
        return $this->belongsTo('App\Zone');
    }
}
