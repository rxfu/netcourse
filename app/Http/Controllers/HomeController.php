<?php

namespace App\Http\Controllers;

use App\Course;
use App\Score;
use Auth;

class HomeController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$courses = Course::whereUserId(Auth::user()->id)->get();

		return view('home', compact('courses'));
	}

	public function student($id) {
		$course   = $id;
		$students = Score::whereCourseId($id)->get();

		return view('student', compact('students', 'course'));
	}
}
