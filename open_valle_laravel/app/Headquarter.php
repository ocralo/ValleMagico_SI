<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Headquarter extends Model
{
    protected $fillable = ['name'];
    /**
     * Computes and returns the institution associated with de current Headquarter instance/row
     * @return Institution
     */
    public function institution(){
        return $this->belongsTo('App\Institution');
    }
    /**
     * Computes and returns the town associated with de current Headquarter instance/row
     * @return Town
     */
    public function town(){
        return $this->belongsTo('App\Town');
    }
}
