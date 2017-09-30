<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
   	public function update()
   	{
   		return view('users.profile');
   	}

   	public function store(Request $request)
   	{
   		auth()->user()->update(['name' => $request->name]);

   		return response(200);
   	}
}
