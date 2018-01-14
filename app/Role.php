<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $appends = ['avatar_path', 'translated_name'];

	protected $with = ['lines'];

	public function getAvatarPathAttribute()
	{
		return '/img/roles/' . $this->slug . '.jpg';		
	}

	public function games()
    {
        return $this->belongsToMany('App\Game')->withTimestamps();
    }	

    public function lines()
    {
    	return $this->hasMany('App\Line');
    }	

    public function getTranslatedNameAttribute()
    {
    	return __('roles.' . $this->slug);
    }
}
