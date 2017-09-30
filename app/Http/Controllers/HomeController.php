<?php

namespace App\Http\Controllers;

use App\Game;
use App\Role;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $good_score = Game::where('is_good_win', true)->where('is_concluded', true)->count();
        $bad_score = Game::where('is_good_win', false)->where('is_concluded', true)->count();
        return view('home', ['users' => User::all(), 'good_score' => $good_score, 'bad_score' => $bad_score, 'total_score' => Game::count() ]);
    }
}
