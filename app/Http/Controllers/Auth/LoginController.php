<?php

namespace App\Http\Controllers\Auth;

use App\Assistant;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller {

	/**
	|--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles authenticating users for the application and
	| redirecting them to your home screen. The controller uses a trait
	| to conveniently provide its functionality to your applications.
	|
	 */

	use AuthenticatesUsers {
		login as protected traitLogin;
	}

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = '/apply';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('guest')->except('logout');
	}

	public function username() {
		return 'username';
	}

	public function login(Request $request) {
		if (Assistant::whereUsername($request->input($this->username()))->exists()) {
			$this->traitLogin($request);
		} else {
			return redirect()->intended($this->redirectPath());
		}
	}
}
