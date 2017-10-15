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

	public function execute($hasCode)
	{
		if( ! $hasCode) return $this->getAuthorizationFirst();

		$user = Socialite::driver('facebook')->user();

		dd($user);
	}

	public function getAuthorizationFirst()
	{
		Socialite::driver('facebook')->redirect();
	}

}