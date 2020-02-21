<?php

Route::get('/', function () {
    return view('welcome');
});


//Route::resource('threads', 'ThreadController');

Route::get('home', 'HomeController@index');
Route::get('threads', 'ThreadController@index');
Route::get('threads/create', 'ThreadController@create');
Route::get('threads/{channel}/{thread}', 'ThreadController@show');
Route::post('threads', 'ThreadController@store');
Route::post('threads/{channel}/{thread}/replies', 'ReplyController@store');
Route::get('threads/{channel}', 'ThreadController@index');
Route::post('replies/{reply}/favorites', 'FavoriteController@store');

Auth::routes();


