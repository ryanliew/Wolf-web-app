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

    public function getAuthUser()
    {
        return auth()->user()->toJson();
    }

    public function getPlayers(Request $request)
    {
    	return User::where('id', '<>', $request->not)->get()->toJson();
    }

    public function createPlayer(Request $request)
    {
        User::create([
            'name' => $request->name,
            'password' => bcrypt('123456'),
            'email' => $request->name . '@email.com',
        ]);
        return 200;
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
    	return Role::where('type', 'good')->orWhere('type', 'bad')->get()->toJson();
    }

    public function getPlayerRoleInGame(Request $request, Game $game)
    {
        $role = $game->users()->where('user_id', $request->user_id)->first()->pivot->role;

        return $role->toJson();
    }

    public function getGame(Game $game)
    {
        return $game->toJson();
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
        if( $game->players()->contains('pivot.role_id', 10) )
        {
            return response(204);
        }

        $winning_roles = Role::where('type', $request->type)->get()->pluck('id');
        $users = $game->users()->wherePivotIn('role_id', $winning_roles)->get();

        $game->update([
            'is_good_win' => $request->type == 'good', 
            'is_concluded' => true
        ]);

        foreach($users as $user)
        {
            $game->users()->updateExistingPivot($user->id, ["score" => $user->pivot->role->default_score]);
        }

        return response(200);
    }

    public function updateUserAvatar(User $user)
    {
        $this->validate(request(), [
            'avatar' => ['required', 'image']
        ]);

        $user->update([
            'avatar_path' => request()->file('avatar')->store('avatars', 'public')
        ]);

        return response([], 204);
    }
}
