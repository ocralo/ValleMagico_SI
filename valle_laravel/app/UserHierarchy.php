<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserHierarchy extends Model
{
    protected $fillable = [
        'user_id', 'destiny_hierarchy_id'
    ];

    /**
     * Computes and returns the User associated with de current User Hierarchy instance/row
     * @return User
     */
    public function user(){
        return $this->belongsTo('App\User');
    }
}
