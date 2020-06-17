<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $fillable = ['name','cod_dane'];
    /**
     * Computes and returns the towns associated with de current Department instance/row
     * @return Array<Town>
     */
    public function towns(){
        return $this->HasMany('App\Town');
    }
}
