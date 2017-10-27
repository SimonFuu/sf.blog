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

Route::group(['prefix' => '/manage', 'namespace' => 'Backend'], function () {
    Route::get('/', function () {
        return view('backend.index');
    }) -> name('adminIndex');
    Route::get('/acl/actions', 'ActionsController@showIndex') -> name('adminActions');
    Route::get('/acl/actions/add', 'ActionsController@showForm') -> name('adminAddActions');
    Route::get('/acl/actions/edit/{id}', 'ActionsController@showForm') -> name('adminEditActions');
    Route::get('/acl/actions/delete/{id}', 'ActionsController@delete') -> name('adminDeleteActions');
    Route::post('/acl/actions/store', 'ActionsController@store') -> name('adminStoreActions');
});


Route::group(['prefix' => '/', 'namespace' => 'Frontend'], function () {
    Route::get('/', 'IndexController@showIndex') -> name('index');

    Route::get('/about', 'IndexController@showAbout') -> name('about');
    Route::get('/archive/{id}', 'ArchivesController@showArchive') -> name('archive');

    Route::get('/blog', 'CategoryController@showCategoryArchives') -> name('blog');

    Route::get('/category/{id}', 'CategoryController@showCategoryArchives') -> name('category');

    Route::get('/daily', 'IndexController@showAllDaily') -> name('daily');

    Route::get('/filing/{month}', 'FilingController@showFilingArchives') -> name('filing');

    Route::get('/resume', 'IndexController@showResume') -> name('resume');
});

