<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
   	return redirect('/login');
});

Auth::routes();
Route::get('/login/facebook', 'Auth\LoginController@redirectToProvider');
Route::get('/login/facebook/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile/{user}', 'UserController@update')->name('profile');

Route::prefix('games')->middleware(['auth'])->group(function() {
	Route::get('/', 'GameController@index');
	Route::get('/create', 'GameController@create');
	Route::post('/create', 'GameController@store');
	Route::get('/edit/{game}', 'GameController@edit');
	Route::post('/edit/{game}', 'GameController@update');

});

Route::get('/game/{game}', 'GameController@show');
Route::delete('/game/{game}', 'GameController@destroy');

Route::prefix('ajax')->middleware(['auth'])->group(function() {
	Route::get('/users', 'AjaxController@getUsers');
	Route::get('/user/profile', 'AjaxController@getAuthUser');
	Route::post('/user/profile', 'UserController@store');
	Route::post('/users/{user}/avatar', 'AjaxController@updateUserAvatar');
	Route::get('/players', 'AjaxController@getPlayers');
	Route::post('/players/create', 'AjaxController@createPlayer');
	Route::get('/roles', 'AjaxController@getRoles');
	Route::get('/game/{game}/player/role', 'AjaxController@getPlayerRoleInGame');
	Route::get('/game/{game}/judge', 'AjaxController@getJudgeInGame');
	Route::get('/game/{game}/players', 'AjaxController@getPlayersInGame');
	Route::post('/game/{game}/role', 'AjaxController@setRoleInGame');
	Route::post('/game/{game}/status', 'AjaxController@setStatusInGame');
	Route::post('/game/{game}/end', 'AjaxController@setEndGame');
	Route::get('/game/{game}', 'AjaxController@getGame');
});
