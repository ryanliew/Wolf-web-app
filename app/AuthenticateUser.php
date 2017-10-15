<?php 

namespace App;

use App\Repositories\UserRepository;
use Laravel\Socialite\Facades\Socialite;

class AuthenticateUser {

	private $users, $socialite;

	function __construct(UserRepository $users)
	{
		$this->users = $users;
	}

	public function execute($hasCode, $listener)
	{
		if( ! $hasCode) return $this->getAuthorizationFirst();

		$user = $this->users->findByUsernameOrCreate($this->getFacebookUser());

		Auth::login($user, true);

		return $listener->userHasLoggedIn($user);
	}

	public function getAuthorizationFirst()
	{
		return Socialite::driver('facebook')->redirect();
	}

	public function getFacebookUser()
	{
		return Socialite::driver('facebook')->user();
	}

}