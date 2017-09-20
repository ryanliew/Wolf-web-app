<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class GameUser extends Pivot
{
    //
    protected $guarded = [];

    public function role()
    {
    	return $this->belongsTo('App\Role');
    }

}
