<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// Route::get('login', function () {
//     return view('auth.login');
// })->name('login');


Route::get('/login', 'Auth\LoginController@getLogin');
Route::post('/login', 'Auth\LoginController@postLogin');
Route::get('/logout', 'Auth\LoginController@getLogout');

// Route::get('logout', function () {
//     Auth::logout();
// 	return redirect('/login');
// })->name('logout');



Route::group(['middleware' => 'auth'], function(){
	
	//Account
 	Route::group(['prefix' => 'account'], function () {
		Route::get('index','AccountController@index');
		Route::get('create','AccountController@create');
		Route::post('create','AccountController@p_create');
		Route::get('modify/{user_id}','AccountController@modify');
		Route::post('modify/{user_id}','AccountController@p_modify');
 		Route::get('reset', 'AccountController@reset');
 		Route::post('reset', 'AccountController@p_reset');
	});
	 
	 //Item
 	Route::group(['prefix' => 'item'], function () {
		Route::get('index', 'ItemController@index');
		Route::get('create', 'ItemController@create');
		Route::post('create', 'ItemController@p_create');
		Route::get('modify/{item_id}', 'ItemController@modify');
		Route::post('modify/{item_id}', 'ItemController@p_modify');
		Route::post('delete/{item_id}', 'ItemController@p_delete');
		Route::get('qrcode/{item_id}', 'ItemController@qrcode');
	});

	//File
	Route::group(['prefix' => 'file'], function () {
		Route::post('/upload', 'FileController@upload');
	
	});

 


	Route::get('/', function () {
		return redirect('item/index');
	});
	 
});

Route::get('/show/{tree_uuid}', 'ShowController@show');



