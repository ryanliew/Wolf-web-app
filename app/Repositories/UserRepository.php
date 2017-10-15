<?php 

namespace App\Repositories;

use App\User;

class UserRepository {

	public function findByUsernameOrCreate($userData)
	{
		$user = User::where('email', $userData->email)->first();
		
		if(!$user)
		{
			$user = User::create([
				'email' => $userData->email,
				'password' => bcrypt('123456'),
				'avatar_path' => $userData->avatar_original,
				'name' => $userData->name
			]);
		}		

		return $user;
	}

}