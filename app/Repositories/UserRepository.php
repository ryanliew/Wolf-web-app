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

		if(!($user->is_user_avatar || $user->is_user_name))
			$user->update(['avatar_path' => $userData->avatar_original, 'name' => $userData->name]);

		return $user;
	}

}