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


Route::group(['prefix' => '1.0'], function () {
    Route::post('userregister',"UserController@userregister");
    Route::post('userLogin', 'UserController@userLogin');

});


Route::group(['prefix' => '1.0','middleware' => 'auth:api'], function () {
    Route::get('all', "NotesController@index");
    Route::get('note/{id}', "NotesController@show");
    Route::get('notes/{id}', "NotesController@notes");
    Route::post('addnote', "NotesController@store");
    Route::post('updatenote', "NotesController@update");
    Route::post('sentbacktonotes', "NotesController@sentbacktonotes");
    Route::post('senttotrash', "NotesController@senttotrash");
    Route::post('updatecolor', "NotesController@updatecolor");
    Route::post('deletenote', "NotesController@destroy");

    Route::post('userdetails', 'UserController@userdetails');
    Route::post('userdetail', 'UserController@userdetail');

});

