<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Line extends Model
{
    public function role()
    {
    	return $this->belongsTo('App\Role');
    }
}
