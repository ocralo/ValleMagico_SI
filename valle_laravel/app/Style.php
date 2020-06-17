<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Style extends Model
{
    /**
     * Computes and returns the Description associated with de current Style instance/row
     * @return Array<DescriptionStyle>
     */
    public function descriptions(){
        return $this->hasMany('App\DescriptionStyle');
    }
}
