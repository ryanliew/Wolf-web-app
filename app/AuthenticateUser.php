<?php 

namespace App;

use App\Repositories\UserRepository;
use Laravel\Socialite\Facades\Socialite;

class AuthenticateUser {

	private $users, $socialite;

	function __construct(UserRepository $users, Socialite $socialite)
	{
		$this->users = $users;
		$this->socialite = $socialite;
	}

	public function execute($hasCode)
	{
		if( ! $hasCode) return $this->getAuthorizationFirst();

		$user = $this->socialite->driver('facebook')->user();

		dd($user);
	}

	public function getAuthorizationFirst()
	{
		$this->socialite->driver('facebook')->redirect();
	}

}