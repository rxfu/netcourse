<?php

namespace App\Http\Controllers;

class HomeController extends Controller {

	public function getDepartments() {
		$items = Department::orderBy('id')->get();

		return response()->json($items);
	}

	public function getCourses() {
		$items = Course::whereIsUsed(false)->get();

		return response()->json($items);
	}

	public function store() {
		return abort(500);
	}
}