<?php 

namespace App\Repositories;

use App\User;

class UserRepository {

	public function findByUsernameOrCreate($userData)
	{
		return User::updateOrCreate(
			[
				'email' =>	$userData->email,
				'password' => bcrypt('123456')
			],
			[
				'avatar_path' => $userData->avatar,
				'name' => $userData->name
			]
		);
	}

}