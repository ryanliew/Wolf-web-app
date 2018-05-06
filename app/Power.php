<?php

namespace App;

use App\GameUser;
use Illuminate\Database\Eloquent\Model;

class Power extends Model
{
    protected $appends = ['avatar_path', 'translated_name'];

    public function role()
    {
    	return $this->belongsTo('App\Role');
    }

    public function getTranslatedNameAttribute()
    {
        return __('powers.' . $this->slug);
    }

    public function getAvatarPathAttribute()
    {
        return '/img/powers/' . $this->slug . '.jpg';     
    }

    public function target()
    {
    	return $this->belongsToMany('App\GameUser', 'player_power', 'power_id', 'target_id')->withPivot('point', 'source_id');
    }

    public function source()
    {
    	return $this->belongsToMany('App\GameUser', 'player_power', 'power_id', 'source_id')->withPivot('point', 'target_id');
    }

    public function determinePoints($target)
    {
        // Wolf gets extra point for killing gods
        if($this->role->slug == 'wolf')
        {
            return $target->role->slug !== 'villager' && $target->role->slug !== 'wolf';
        }

    	return $target->role->type == $this->role->type ? -$this->has_penalty : 1;

    }
}
