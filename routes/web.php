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
	return redirect('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/student/{id}', 'HomeController@student')->name('student');
Route::put('/score', 'HomeController@score');
Route::post('/confirm', 'HomeController@confirm');
