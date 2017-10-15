<?php 

namespace App\Repositories;

use App\User;

class UserRepository {

	public function findByUsernameOrCreate($userData)
	{
		return User::firstOrCreate(
			[
				'email' =>	$userData->email,
				'password' => bcrypt('123456')
			]
		);
	}

}