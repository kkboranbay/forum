<?php

Route::get('/', function () {
    return view('welcome');
});

//Route::resource('threads', 'ThreadController');

Route::get('home', 'HomeController@index');
Route::get('threads', 'ThreadController@index')->name('threads');
Route::get('threads/create', 'ThreadController@create');
Route::get('threads/search', 'SearchController@show');
Route::get('threads/{channel}/{thread}', 'ThreadController@show');
Route::patch('threads/{channel}/{thread}', 'ThreadController@update');
Route::delete('threads/{channel}/{thread}', 'ThreadController@destroy');
Route::post('threads', 'ThreadController@store')->middleware('must-be-confirmed');
Route::post('threads/{channel}/{thread}/replies', 'ReplyController@store')->name('reply.store');
Route::get('threads/{channel}/{thread}/replies', 'ReplyController@index');
Route::get('threads/{channel}', 'ThreadController@index');
Route::post('replies/{reply}/favorites', 'FavoriteController@store');
Route::delete('replies/{reply}/favorites', 'FavoriteController@destroy');
Route::delete('replies/{reply}', 'ReplyController@destroy')->name('reply.destroy');

Route::post('locked-threads/{thread}', 'LockedThreadController@store')->name('locked_thread.store')->middleware('admin');
Route::delete('locked-threads/{thread}', 'LockedThreadController@destroy')->name('locked_thread.destroy')->middleware('admin');


Route::post('replies/{reply}/best', 'BestReplyController@store')->name('best-reply.store');

Route::patch('replies/{reply}', 'ReplyController@update');

Route::post('threads/{channel}/{thread}/subscription', 'ThreadSubscriptionController@store');
Route::delete('threads/{channel}/{thread}/subscription', 'ThreadSubscriptionController@destroy');

Route::get('profiles/{user}', 'ProfileController@show')->name('profile');
Route::get('profiles/{user}/notifications', 'UserNotificationController@index');
Route::delete('profiles/{user}/notifications/{notification}', 'UserNotificationController@destroy');

Route::get('api/users', 'Api\UserController@index');
Route::post('api/users/{user}/avatar', 'Api\UserAvatarController@store')->middleware('auth')->name('avatar');

Route::get('/register/confirm', 'Auth\RegisterConfirmationController@index')->name('register.confirm');

Auth::routes();

Route::view('scan', 'scan');



