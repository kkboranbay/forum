<?php

Route::get('/', function () {
    return view('welcome');
});


Route::resource('threads', 'ThreadController');
Route::get('/threads', 'ThreadController@index');
Route::get('/threads/{channel}/{thread}', 'ThreadController@show');
Route::post('/threads/{channel}/{thread}/replies', 'ReplyController@store');
Route::post('/threads', 'ThreadController@store');

Auth::routes();


