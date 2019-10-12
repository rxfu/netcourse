<?php

namespace App\Http\Controllers;

use App\Assistant;
use App\Course;
use App\Department;
use App\Score;
use App\Student;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware('auth')->except('getAssistantForm', 'postAddAssistant');
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
			$courses = Course::whereAssistantId(Auth::user()->id)->get();
		}

		return view('home', compact('courses'));
	}

	public function student($course) {
		$course   = $course;
		$students = Score::whereCourseId($course)->orderBy('card_id')->get();

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

	public function getAssistant(Request $request) {
		$id = $request->input('id');

		if (Assistant::whereId($id)->exists()) {
			$assistant = Assistant::findOrFail($id);

			return response()->json([
				'assistant' => $assistant,
			]);
		}
	}

	public function getAssistantForm() {
		if (Auth::check()) {
			$assistant = Auth::user();
		} else {
			$assistant = null;
		}
		$departments = Department::orderBy('id')->get();

		return view('assistant', compact('departments', 'assistant'));
	}

	public function postAddAssistant(Request $request) {
		if ($request->isMethod('post')) {
			$this->validate($request, [
				'id'            => 'required',
				'name'          => 'required',
				'department_id' => 'required',
				'phone'         => 'required',
			]);

			if (Student::whereXh($request->input('id'))->exists()) {
				$request->session()->flash('status', '本科生不允许申请助教');

				return back();
			}

			$exists = Assistant::whereId($request->input('id'))->exists();
			if (!$exists) {
				$assistant = new Assistant;
				$assistant->fill($request->all());
				$assistant->username = $assistant->phone;
				$assistant->password = str_random(8);
				$status              = $assistant->save();
				$message             = $status ? '提交成功' : '提交失败';
			} else {
				$assistant = Assistant::findOrFail($request->input('id'));
				$assistant->fill($request->all());
				$assistant->save();
				$message = '已有助教信息';
			}

			$request->session()->flash('status', $message);

			return redirect('/courses');
		}

		return abort(405);
	}

	public function getCourses() {
		$exists = Assistant::whereId(Auth::user()->id)->exists();

		if ($exists) {
			$assistant = Assistant::findOrFail(Auth::user()->id);

			$exists = Course::whereAssistantId($assistant->id)->exists();
			if (!$exists) {
				$courses = Course::whereIsUsed(false)->get();
			} else {
				$courses = Course::whereAssistantId($assistant->id)->get();
			}

			return view('course', compact('assistant', 'courses', 'exists'));
		}
	}

	public function patchUpdateCourses(Request $request) {
		if ($request->isMethod('patch')) {
			foreach ($request->input('qqun') as $key => $value) {
				$rules['qqun.' . $key] = 'required|numeric';
			}
			$this->validate($request, $rules);

			$exists = Course::whereAssistantId(Auth::user()->id)->exists();

			if (!$exists) {
				$ids = $request->input('id');
				$qquns = $request->input('qqun');
				$memos = $request->input('memo');

				foreach ($ids as $key => $id) {
					$course               = Course::findOrFail($id);
					$course->is_used      = true;
					$course->assistant_id = Auth::user()->id;
					$course->qqun         = $qquns[$key];
					$course->memo         = $memos[$key];
					$course->save();
				}

				$status  = true;
				$message = '申请成功';

			} else {
				$status  = false;
				$message = '申请失败，你已经选过课了';
			}

			$request->session()->flash('status', $message);

			return back();
		}

		return abort(405);
	}
}
