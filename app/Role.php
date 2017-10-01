<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $appends = ['avatar_path'];

	public function getAvatarPathAttribute()
	{
		return '/img/roles/' . $this->slug . '.jpg';		
	}

	public function games()
    {
        return $this->belongsToMany('App\Game')->withTimestamps();
    }		
}
