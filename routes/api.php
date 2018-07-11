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

Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');

Route::group(['prefix' => '1.0','middleware' => 'auth:api'], function () {
    Route::get('all', "NotesController@index");
    Route::get('note/{id}', "NotesController@show");
    Route::post('addnote', "NotesController@store");
    Route::post('updatenote/{id}', "NotesController@update");
    Route::post('deletenote/{id}', "NotesController@destroy");
});

