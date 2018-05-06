<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    //
    protected $guarded = [];

    protected $with = ['roles'];

    public function users()
    {
    	return $this->belongsToMany('App\User')->withPivot('role_id', 'score', 'status', 'is_alive', 'seat')->withTimestamps();
    }

    public function gameUsers()
    {
        return $this->hasMany('App\GameUser');
    }

    public function gamePlayers()
    {
        return $this->gameUsers()->where('role_id', '<>', '1')->get();
    }

    public function players()
    {
    	return $this->users()->wherePivot('role_id', '<>', '1')->get();
    }

    public function judge()
    {
    	return $this->users()->wherePivot('role_id', '=', '1')->first();
    }

    public function roles()
    {
        return $this->belongsToMany('App\Role')->withTimestamps();
    }

    public function getWinSideImgAttribute()
    {
        $img = "/img/roles/unknown.jpg";

        if( $this->is_concluded )
        {
            $img = $this->is_good_win ? "/img/roles/villager.jpg" : "/img/roles/wolf.jpg";
        }
        return $img;
    }

    public function getWinSideColorAttribute()
    {
        $color = "grey";

        if( $this->is_concluded )
        {
            $color = $this->is_good_win ? "#2ab27b" : "#FF5252";
        }

        return $color;
    }

    public function authenticate_user($user)
    {
        return true;//$this->is_concluded || !$this->players()->contains('id', $user);
    }
    
    /***** Scopes *****/
    public function scopePlaying($query)
    {
        return $query->where('role_id', '<>', 1 );
    }

    public function scopeWin($query)
    {
        return $query->where('score', '>', 0);
    }

    public function scopeConcluded($query)
    {
        return $query->where('is_concluded', true);
    }
}
