<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    //
    protected $guarded = [];

    public function users()
    {
    	return $this->belongsToMany('App\User')->withPivot('role_id', 'score', 'status', 'is_alive', 'seat')->using('App\GameUser');
    }

    public function players()
    {
    	return $this->users()->wherePivot('role_id', '<>', '1')->get();
    }

    public function judge()
    {
    	return $this->users()->wherePivot('role_id', '=', '1')->first();
    }
}
