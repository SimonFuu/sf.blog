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

Route::group(['prefix' => '/', 'namespace' => 'Frontend'], function () {
    Route::get('/', 'IndexController@showIndex');
});

Route::group(['prefix' => 'blog', 'namespace' => 'Frontend\\Blog'], function () {
    Route::get('/', 'CategoryController@showCategoryArchives');
    Route::get('/category/{id}', 'CategoryController@showCategoryArchives');
    Route::get('/archive/{id}', 'ArchivesController@showArchive');
});
Route::group(['namespace' => 'Frontend'], function () {
    Route::get('/about', 'IndexController@showAbout');
});
