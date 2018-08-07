<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GameUser extends Model
{
    //
    protected $guarded = [];

    protected $table = 'game_user';

    protected $appends = ['is_killed_by_poison', 'is_killed_by_assassin', 'is_killed_by_hunter'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function role()
    {
    	return $this->belongsTo('App\Role');
    }

    public function powerAsTarget()
    {
    	return $this->belongsToMany('App\Power', 'player_power', 'target_id', 'power_id')->withPivot('point', 'source_id')->withTimestamps();
    }

    public function powerAsSource()
    {
    	return $this->belongsToMany('App\Power', 'player_power', 'source_id', 'power_id')->withPivot('point', 'target_id')->withTimestamps();
    }

    public function getIsKilledByPoisonAttribute()
    {
        return $this->powerAsTarget->filter(function($power){ return $power->slug == 'poison';})->count() > 0;
    }

    public function getIsKilledByHunterAttribute()
    {
        return $this->powerAsTarget->filter(function($power){ return $power->slug == 'shoot';})->count() > 0;
    }

    public function getIsKilledByAssassinAttribute()
    {
        return $this->powerAsTarget->filter(function($power){ return $power->slug == 'assassinate';})->count() > 0;
    }
}
