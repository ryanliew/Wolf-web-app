<?php

namespace App\Http\Controllers;

use App\GameUser;
use App\Power;
use Illuminate\Http\Request;

class PowerController extends Controller
{
    public function execute()
    {
    	$power = Power::find(request()->power);

    	$target = GameUser::where('game_id', request()->game_id)->where('seat', request()->target)->first();

    	$points = $power->has_target ? $power->determinePoints($target) : 0;

    	$power->source()->attach(request()->source, ['target_id' => $target->id, 'point' => $points]);

    	if($power->slug == 'examine') return $target->role->type;

    	if($power->slug == 'demon-examine') return $target->role->slug;
    }
}
