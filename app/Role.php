<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $append = ['score'];

	public function games()
	{
		return $this->hasMany('App\GameUser');
	}

	public function getScoreAttribute()
	{
		return $this->games()->sum('score');
	}

	public function getWinRateAttribute()
	{
		if($this->games()->count() == 0)
			return 0;

		return $this->games()->where('score', '>', '0')->count() / $this->games()->count() * 100;
	}
}
