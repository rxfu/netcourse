<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

class PasswordController extends Controller {

	public function password() {
		return view('password');
	}

	public function change(Request $request) {
		$this->validate($request, [
			'old_password'          => 'required',
			'password'              => 'required|min:6|confirmed',
			'password_confirmation' => 'required|min:6',
		]);

		list($old, $password, $confirm) = array_values($request->only('old_password', 'password', 'password_confirmation'));

		$user = $request->user();
		if (Auth::attempt(['username' => $user->username, 'password' => $old])) {
			if ($password === $confirm && mb_strlen($password) >= 6) {
				$user->password = $password;
				$user->save();

				$request->session()->flash('status', '修改密码成功');
				return back();
			}
		}

		$request->session()->flash('status', '修改密码失败');
		return back();
	}
}
