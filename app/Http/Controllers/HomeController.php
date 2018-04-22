<?php

namespace App\Http\Controllers;

use App\Assistant;
use App\Course;
use App\Department;
use Illuminate\Http\Request;

class HomeController extends Controller {

	private $asid;

	public function getDepartments() {
		$items = Department::orderBy('id')->get();

		return response()->json($items);
	}

	public function getCourses($asid) {
		$exists = Assistant::whereCardId($asid)->exists();

		if ($exists) {
			$assistant = Assistant::whereCardId($asid)->first();

			$exists = Course::whereAssistantId($assistant->id)->exists();
			if (!$exists) {
				$items = Course::whereIsUsed(false)->get();

				return response()->json([
					'status'    => true,
					'assistant' => $assistant,
					'courses'   => $items,
				]);

			} else {
				return response()->json([
					'status'  => false,
					'message' => 'fail',
				]);
			}
		}
	}

	public function postAddAssistant(Request $request) {
		if ($request->ajax() && $request->isMethod('post')) {
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

			return response()->json([
				'status'  => $status,
				'message' => $message,
			]);
		}

		return abort(500);
	}

	public function postUpdateCourses(Request $request, $asid) {
		if ($request->ajax() && $request->isMethod('post')) {
			$aid    = Assistant::whereCardId($asid)->first()->id;
			$exists = Course::whereAssistantId($aid)->exists();

			if (!$exists) {
				foreach ($request->all() as $id) {
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
