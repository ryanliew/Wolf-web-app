<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
   	public function update(User $user)
   	{
   		return view('users.profile', ['roles' => Role::where('id', '<>', 1)->where('slug', '<>', 'unknown')->get(), 'user' => $user]);
   	}

   	public function store(Request $request)
   	{
   		auth()->user()->update(['name' => $request->name, 'is_user_name' => true]);

   		return response(200);
   	}
}
