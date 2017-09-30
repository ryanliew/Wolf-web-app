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

    protected $append = [
        'score'
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
        if($this->games()->count() <= 0)
            return 0;
        
        return $this->games()->where('score', '>', '0')->where('role_id', '<>', 1 )->count() / $this->games()->count() * 100;
    }

    public function getAvatarPathAttribute($avatar)
    {
        return asset( $avatar ? 'storage/' . $avatar : "storage/avatars/default.jpg");
    }
}
