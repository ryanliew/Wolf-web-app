<?php

namespace App\Http\Controllers;

use App\Game;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function getUsers(Request $request)
    {
    	return User::all()->toJson();
    }

    public function getPlayers(Request $request)
    {
    	return User::where('id', '<>', $request->not)->get()->toJson();
    }

    public function getJudgeInGame(Game $game)
    {
    	return $game->judge();
    }
    
    public function getPlayersInGame(Game $game)
    {
    	return $game->players()->toJson();
    }

    public function getRoles()
    {
    	return Role::all()->toJson();
    }

    public function setRoleInGame(Request $request, Game $game)
    {
        $game->users()->updateExistingPivot($request->user_id, ["role_id" => $request->role_id]);
        return response(200);
    }

    public function setStatusInGame(Request $request, Game $game)
    {
        $game->users()->updateExistingPivot($request->user_id, ["is_alive" => $request->alive]);
        return response(200);
    }

    public function setEndGame(Request $request, Game $game)
    {
        $winning_roles = Role::where('type', $request->type)->get()->pluck('id');
        $users = $game->users()->wherePivotIn('role_id', $winning_roles)->get();

        foreach($users as $user)
        {
            $game->users()->updateExistingPivot($user->id, ["score" => $user->pivot->role->default_score]);
        }

        return response(200);
    }
}
