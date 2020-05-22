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
    return view('welcome');
});

Route::resource('post','PostController');
Auth::routes();

Route::get('/search','PostController@search');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/user/{id}', 'HomeController@userProfile');
// Route::get('/user/{id}', 'HomeController@index')->name('home');
Route::get('/category/{cat_id}','Category@getPostsByCategory');
Route::get('/like','PostController@likePost')->name('like');
// Route::get('image-upload', 'ImageUploadController@imageUpload')->name('image.upload');
// Route::post('image-upload', 'ImageUploadController@imageUploadPost')->name('image.upload.post');

Route::get('/like/{id}', 'PostController@likePost');