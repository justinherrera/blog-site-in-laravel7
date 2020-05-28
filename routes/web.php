<?php

use Illuminate\Support\Facades\Route;

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
    return redirect('/login');
});

Route::resource('post','PostController');
Route::resource('comments','CommentController');
Auth::routes();

Route::get('/search','PostController@search');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user/{id}', 'HomeController@userProfile');
// Route::get('/user/{id}', 'HomeController@index')->name('home');
Route::get('/category/{cat_id}','Category@getPostsByCategory');
// Route::get('/like','PostController@likePost')->name('like');
// Route::get('image-upload', 'ImageUploadController@imageUpload')->name('image.upload');
// Route::post('image-upload', 'ImageUploadController@imageUploadPost')->name('image.upload.post');

Route::get('/like/{id}', 'PostController@likePost')->name('post.likePost');
Route::get('/unlike/{id}', 'PostController@unlikePost'); // route for unlike
// Route::get('/like/{id}', 'PostController@updatelikePost');
Route::get('/dislike/{id}', 'PostController@dislikePost')->name('post.dislikePost');
Route::get('/undislike/{id}', 'PostController@undislikePost'); // route for undislike