<?php 

namespace App\Repositories;

use App\User;

class UserRepository {

	public function findByUsernameOrCreate($userData)
	{
		$user = User::firstOrCreate(
			[
				'email' =>	$userData->email,
				'password' => bcrypt('123456')
			]
		);

		$user->update(['avatar_path' => $userData->avatar, 'name' => $userData->name]);

		return $user;
	}

}