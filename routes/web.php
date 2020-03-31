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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('posts')->group(function () {

    Route::get('/', [
      'as' => 'post.index',
      'uses' => 'PostsController@getBlogIndex'
    ]);

    Route::get('/{id}', [
      'as' => 'post.single.index',
      'uses' => 'PostsController@getBlogIndex'
    ]);
});

Route::prefix('comments')->group(function () {

    Route::get('/', [
      'as' => 'comment.index',
      'uses' => 'CommentController@getCommentIndex'
    ]);

    Route::get('/{id}', [
      'as' => 'comment.single.index',
      'uses' => 'CommentController@getCommentIndex'
    ]);

    Route::post('/', [
      'as' => 'comment.post.index',
      'uses' => 'CommentController@postCommentIndex'
    ]);
});