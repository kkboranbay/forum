<?php

Route::get('/', function () {
    return view('welcome');
});


Route::resource('threads', 'ThreadController');
Route::post('/threads/{thread}/replies', 'ReplyController@store');

Auth::routes();


