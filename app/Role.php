<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	public function getAvatarPathAttribute()
	{
		return '/img/roles/' . $this->slug . '.jpg';		
	}		
}
