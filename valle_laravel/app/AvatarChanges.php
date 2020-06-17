<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AvatarChanges extends Model
{
    protected $fillable = [
        'avatar_name', 'game_user_id', 'avatar_id'
    ];
    /**
     * Computes and returns the list of all User associated with de current GameUser instance/row
     * Only for Save using ORM, not usefull as GET.
     * @return Array<Avatar>
     */
    public function users(){
        return $this->belongsToMany('App\User','avatar_changes');
    }
}
