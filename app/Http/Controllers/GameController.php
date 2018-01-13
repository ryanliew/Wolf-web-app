<?php

namespace App\Http\Controllers;

use App\Game;
use App\Role;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth'); 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('games.index', ["games" => Game::latest()->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('games.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $game = Game::create();
        
        $players = collect($request->players)->shuffle();

        $game->roles()->sync($request->roles);

        $game->users()->sync($players->all());

        foreach($game->users as $key => $player)
        {
            $role_id = request()->autofill ? 5 : 10;
            $game->users()->updateExistingPivot($player->id, ['seat' => $key + 1, 'role_id' => $role_id]);
        }

        $game->users()->attach($request->judge, ['role_id' => 1, 'score' => 1]);

        if($request->autofill) $this->auto_fill_roles($game, $players);

        return $game->id;
    }

    public function auto_fill_roles($game)
    {
        // Get roles actual
        $roles = Role::whereIn('id', request()->roles)->get();

        // Reshuffle users for assigning roles 1 by 1
        $shuffled = $game->players()->shuffle();
        $index = 0;
        // Assign wolf
        // Wolf number = number of players / 3 round half up
        $wolf_number = round($shuffled->count() / 3, 0, PHP_ROUND_HALF_UP);
        $villager_number = ceil($shuffled->count() / 3);

        // Assign wolf god
        $wolf_gods = $roles->filter(function($value){
            return $value->type == "bad" && $value->slug !== "wolf";
        });

        foreach($wolf_gods as $wgod)
        {
            $this->assignRole($game, $shuffled[$index]->id, $wgod->id);
            $index++;
            $wolf_number--;
        }

        // Assign gods
        $gods = $roles->filter(function($value){
            return $value->type == "good" && $value->slug !== "villager";
        });

        foreach($gods as $god)
        {
            $this->assignRole($game, $shuffled[$index]->id, $god->id);
            $index++;
        }

        // Assign wolf
        $wolf = $roles->filter(function($value){
            return $value->slug == "wolf";
        })->first();

        for($i = 0; $i < $wolf_number; $i++)
        {
            $this->assignRole($game, $shuffled[$index]->id, $wolf->id);
            $index++;
        }

        // Assign villagers
    }

    public function assignRole($game, $player_id, $role_id)
    {
        $game->users()->updateExistingPivot($player_id, ['role_id' => $role_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {
        if( !$game->authenticate_user(auth()->id()) )
            return back()->with('flash', '游戏还在进行中');

        return view('games.view', ['game' => $game]);
    }

    public function roles(Game $game)
    {
        if( !$game->authenticate_user(auth()->id()) )
            return back()->with('flash', '游戏还在进行中');

        return view('games.role', ['game' => $game]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Game $game)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        //
    }
}
