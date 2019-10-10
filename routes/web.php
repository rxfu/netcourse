<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
/*
Route::get('{path}', function () {
return view('index');
})->where('path', '(.*)');
 */
Route::get('/', function () {
	// return redirect('home');
	return redirect('/courses');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/courses', 'HomeController@getCourses');
Route::get('/assistant', 'HomeController@getAssistant');
Route::get('/apply', 'HomeController@getAssistantForm');
Route::post('/apply', 'HomeController@postAddAssistant');
Route::patch('/update', 'HomeController@patchUpdateCourses');

Route::group(['middleware' => ['auth']], function () {
	Route::get('/password', 'PasswordController@password')->name('password');
	Route::put('/password', 'PasswordController@change');
});
Route::group(['middleware' => ['App\Http\Middleware\CheckCourse']], function () {
	Route::get('/student/{course}', 'HomeController@student')->name('student');
	Route::post('/score', 'HomeController@confirm');
	Route::put('/score', 'HomeController@score');
});
