<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /*
    protected $fillable = [
        'name', 'email', 'password',
    ];*/
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'score', 'short_name'
    ];

    public function games()
    {
        return $this->belongsToMany('App\Game')->withPivot('role_id', 'score', 'status', 'is_alive', 'seat')->using('App\GameUser')->withTimestamps();
    }

    public function getScoreAttribute()
    {
        return $this->games()->sum('score');
    }

    public function getWinRateAttribute()
    {
        if($this->total_games <= 0)
            return 0;
        
        return $this->games()->playing()->win()->count() / $this->total_games * 100;
    }

    public function getTotalGamesAttribute()
    {
        return $this->games()->where('is_concluded', 1)->playing()->count();
    }

    public function getAvatarPathAttribute($avatar)
    {
        if(strpos($avatar, 'facebook') !== false )
            return $avatar;
           
        return asset( $avatar ? 'storage/' . $avatar : "/img/default.jpg");
    }

    public function getWinRateForRole($role_id)
    {
        $count = $this->getCountForRole($role_id);
        return $count > 0 ? $this->getWinCountForRole($role_id) / $this->getCountForRole($role_id) * 100 : 0;
    }

    public function getWinCountForRole($role_id)
    {
        return $this->games()->where('role_id', $role_id)->playing()->win()->count();
    }

    public function getCountForRole($role_id)
    {
        return $this->games()->concluded()->where('role_id', $role_id)->count();
    }

    public function getRateForRole($role_id)
    {
        $total = $this->games()->playing()->count();
        return $total > 0 ? $this->getCountForRole($role_id) / $total * 100 : 0;
    }

    public function getShortNameAttribute()
    {
        return substr( $this->name, 0, 7 );
    }
}
