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
    return 111;
});
Route::group(['prefix' => '/manage', 'namespace' => 'Backend'], function () {
    Route::get('/', function () {
        return view('backend.index');
    });
});


Route::group(['prefix' => '/', 'namespace' => 'Frontend'], function () {
    Route::get('/', 'IndexController@showIndex');

    Route::get('/about', 'IndexController@showAbout');
    Route::get('/archive/{id}', 'ArchivesController@showArchive');

    Route::get('/blog', 'CategoryController@showCategoryArchives');

    Route::get('/category/{id}', 'CategoryController@showCategoryArchives');

    Route::get('/daily', 'IndexController@showAllDaily');

    Route::get('/filing/{month}', 'FilingController@showFilingArchives');

    Route::get('/resume', 'IndexController@showResume');
});

