<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;

class ProfileController extends Controller
{
	public function edit() {
		
		$loggedInUser = \Auth::user();
		
		return view('admin.profile.edit', [
			'user' => $loggedInUser
		]);
	}
	
	public function update() {
		
		$loggedInUser = \Auth::user();
		
		$request = request();
		
		$formData = $request->validate([
			'name' => 'required|string|min:2',
			'email' => 'required|email|unique:users,email,' . $loggedInUser->id
		]);
		
		$loggedInUser->fill($formData);
		$loggedInUser->save();
		
		return redirect()->back()
				->with('systemMessage', 'You have updated your profile!');
	}
	
	public function changePassword() {
		
		return view('admin.profile.change-password');
	}
	
	public function updatePassword() {
		$loggedInUser = \Auth::user();
		
		$request = request();
		
		$formData = $request->validate([
			'old_password' => 'required|string',
			'password' => 'required|string|min:5',
			'password_confirmation' => 'required|same:password'
		]);
		
		//reload model row from database
		$loggedInUser->fresh();
		
		if(!\Hash::check($formData['old_password'], $loggedInUser->password)) {
			return redirect()->back()
					->with('systemError', 'Old password is incorrect!');
		}
		
		$loggedInUser->password = bcrypt($formData['password']);
		$loggedInUser->save();
		
		return redirect()->back()
				->with('systemMessage', 'Your password has been changed!');
	}
}
