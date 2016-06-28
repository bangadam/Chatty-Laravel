<?php
/*Home Index*/
Route::get('/', [
  'uses' => '\Chatty\Http\Controllers\HomeController@index',
  'as'   => 'home',
]);

/* Authenticate */
Route::get('/signup', [
  'uses'  => '\Chatty\Http\Controllers\AuthController@getSignUp',
  'as'  =>  'auth.signup',
  'middleware' => ['guest'],
]);

Route::post('/signup', [
  'uses'  => '\Chatty\Http\Controllers\AuthController@postSignUp',
  'middleware' => ['guest'],
]);

Route::get('/signin', [
  'uses'  => '\Chatty\Http\Controllers\AuthController@getSignIn',
  'as'  =>  'auth.signin',
  'middleware' => ['guest'],
]);

Route::post('/signin', [
  'uses'  => '\Chatty\Http\Controllers\AuthController@postSignIn',
  'middleware' => ['guest'],
]);

Route::get('/signout', [
  'uses'  => '\Chatty\Http\Controllers\AuthController@getSignOut',
  'as'  =>  'auth.signout',
]);


/*
*Search
*/

Route::get('/search', [
  'uses'  =>  '\Chatty\Http\Controllers\SearchController@getResults',
  'as'    =>  'search.results',
]);

/*
* Profile
*/

Route::get('/user/{username}', [
  'uses'  =>  '\Chatty\Http\Controllers\ProfileController@getProfile',
  'as'    =>  'profile.index',
]);

Route::get('/profile/edit', [
  'uses'  =>  '\Chatty\Http\Controllers\ProfileController@getEdit',
  'as'    =>  'profile.edit',
  'middleware' => ['auth'],
]);

Route::post('/profile/edit', [
  'uses'  =>  '\Chatty\Http\Controllers\ProfileController@postEdit',
  'middleware' => ['auth'],
]);


/*
* Friends
*/

Route::get('/friend', [
  'uses'  =>  '\Chatty\Http\Controllers\FriendController@getIndex',
  'as'    =>  'friend.index',
  'middleware' => ['auth'],
]);

Route::get('/friend/add/{username}', [
  'uses'  =>  '\Chatty\Http\Controllers\FriendController@getAdd',
  'as'    =>  'friend.add',
  'middleware' => ['auth'],
]);

Route::get('/friend/accept/{username}', [
  'uses'  =>  '\Chatty\Http\Controllers\FriendController@getAccept',
  'as'    =>  'friend.accept',
  'middleware'  =>  ['auth'],
]);

Route::post('/friend/delete/{username}', [
  'uses'  =>  '\Chatty\Http\Controllers\FriendController@postDelete',
  'as'    =>  'friend.delete',
  'middleware'  =>  ['auth'],
]);

/**
* statuses
*/

Route::post('/status', [
  'uses'  =>  '\Chatty\Http\Controllers\StatusController@postStatus',
  'as'    =>  'status.post',
  'middleware'  =>  ['auth'],
]);

Route::post('/status/{statusId}/reply', [
  'uses'  =>  '\Chatty\Http\Controllers\StatusController@postReply',
  'as'    =>  'status.reply',
  'middleware'  =>  ['auth'],
]);

Route::get('/status/{statusId}/like', [
  'uses'  =>  '\Chatty\Http\Controllers\StatusController@getLike',
  'as'    =>  'status.like',
  'middleware'  =>  ['auth'],
]);
