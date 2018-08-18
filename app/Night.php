<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Night extends Model
{
	protected $guarded = [];
	
    public function game()
    {
    	return $this->belongsTo('App\Game');
    }
}
