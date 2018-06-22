<?php

namespace App\Http\Controllers;

use App\Course;
use App\Score;
use Auth;
use Illuminate\Http\Request;

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

	public function student($course) {
		$course   = $course;
		$students = Score::whereCourseId($course)->get();

		return view('student', compact('students', 'course'));
	}

	public function score(Request $request) {
		if ($request->isMethod('put')) {
			$request->validate([
				'score' => 'required|integer|min:0|max:100',
			]);

			$score = Score::findOrFail($request->input('id'));

			$score->score = $request->input('score');
			$score->save();
		}
	}

	public function confirm(Request $request) {
		if ($request->isMethod('post')) {
			Score::whereCourseId($request->input('course'))->update(['is_confirmed' => true]);

			$request->session()->flash('提交成功');
		}

		return back();
	}
}
