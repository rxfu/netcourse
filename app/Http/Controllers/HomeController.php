<?php

namespace App\Http\Controllers;

use App\Course;
use App\Department;
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
		$this->middleware('auth')->except('getAssistant');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		if (Auth::user()->username === 'admin') {
			$courses = Course::orderBy('id')->get();
		} else {
			$courses = Course::whereUserId(Auth::user()->id)->get();
		}

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
			$request->validate([
				'score' => 'required|integer|min:0|max:100',
			]);

			Score::whereCourseId($request->input('course'))->update(['is_confirmed' => true]);

			$request->session()->flash('提交成功');
		}

		return back();
	}

	private $asid;

	public function getAssistant() {
		$departments = Department::orderBy('id')->get();

		return view('assistant', compact('departments'));
	}

	public function getCourses($asid) {
		$exists = Assistant::whereCardId($asid)->exists();

		if ($exists) {
			$assistant = Assistant::whereCardId($asid)->first();

			$exists = Course::whereAssistantId($assistant->id)->exists();
			if (!$exists) {
				$courses = Course::whereIsUsed(false)->get();
			}

			return view('course', compact('assistant', 'courses'));
		}
	}

	public function postAddAssistant(Request $request) {
		if ($request->isMethod('post')) {
			$this->validate($request, [
				'card_id'       => 'required',
				'name'          => 'required',
				'department_id' => 'required',
				'phone'         => 'required',
			]);

			$exists = Assistant::whereCardId($request->input('card_id'))->exists();
			if ($exists) {
				$status  = true;
				$message = 'already applied';
			} else {
				$assistant = new Assistant;
				$assistant->fill($request->all());
				$status  = $assistant->save();
				$message = $status ? 'success' : 'failed';
			}

			return $status ? $request->session()->flash('提交成功') : $request->session()->flash('提交失败');
		}

		return abort(500);
	}

	public function postUpdateCourses(Request $request, $asid) {
		if ($request->isMethod('post')) {
			$aid    = Assistant::whereCardId($asid)->first()->id;
			$exists = Course::whereAssistantId($aid)->exists();

			if (!$exists) {
				foreach (array_column($request->all(), 'id') as $id) {
					$course               = Course::findOrFail($id);
					$course->is_used      = true;
					$course->assistant_id = $aid;
					$course->save();
				}

				$status  = true;
				$message = 'success';

			} else {
				$status  = false;
				$message = 'fail';
			}

			return response()->json([
				'status'  => $status,
				'message' => $message,
			]);
		}

		return abort(500);
	}
}
