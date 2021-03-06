<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});

Route::group(['middleware' => ['guest:api']], function () {
	Route::get('/departments', 'HomeController@getDepartments');
	Route::get('/{asid}/courses', 'HomeController@getCourses');
	Route::post('/apply', 'HomeController@postAddAssistant');
	Route::post('/{asid}/update', 'HomeController@postUpdateCourses');
});
