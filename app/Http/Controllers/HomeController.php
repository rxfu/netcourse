<?php

namespace App\Http\Controllers;

use App\Assistant;
use App\Course;
use App\Department;
use Illuminate\Http\Request;

class HomeController extends Controller {

	public function getDepartments() {
		$items = Department::orderBy('id')->get();

		return response()->json($items);
	}

	public function getCourses() {
		$items = Course::whereIsUsed(false)->get();

		return response()->json($items);
	}

	public function postAddAssistant(Request $request) {
		if ($request->ajax() && $request->isMethod('post')) {
			$this->validate($request, [
				'card_id'       => 'required',
				'name'          => 'required',
				'department_id' => 'required',
				'phone'         => 'required',
			]);

			$assistant = new Assistant;
			$assistant->fill($request->all());
			if ($assistant->save()) {
				return response()->json(['message' => 'Add successfully!']);
			} else {
				return response()->json(['message' => 'Add failed!']);
			}
		}

		return abort(500);
	}

	public function postUpdateCourses(Request $request) {
		if ($request->ajax() && $request->isMethod('post')) {
			foreach ($request->all() as $id) {
				$course          = Course::findOrFail($id);
				$course->is_used = true;
				$course->save();
			}

			if (true) {
				return response()->json(['message' => 'Add successfully!']);
			} else {
				return response()->json(['message' => 'Add failed!']);
			}
		}

		return abort(500);
	}
}
