<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCrudRecord extends Model
{
    /**
     * Computes and returns the User associated with de current UserCRUD Record instance/row
     * @return User
     */
    public function user(){
        return $this->belongsTo('App\User');
    }
}
