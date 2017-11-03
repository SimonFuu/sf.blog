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

Route::group(['prefix' => '/', 'namespace' => 'Frontend', 'middleware' => 'frontend'], function () {
    Route::get('/', 'IndexController@showIndex') -> name('index');

    Route::get('/about', 'IndexController@showAbout') -> name('about');
    Route::get('/archive/{id}', 'ArchivesController@showArchive') -> name('archive');

    Route::get('/blog', 'CategoryController@showCategoryArchives') -> name('blog');

    Route::get('/category/{id}', 'CategoryController@showCategoryArchives') -> name('category');

    Route::get('/daily', 'IndexController@showAllDaily') -> name('daily');

    Route::get('/filing/{month}', 'FilingController@showFilingArchives') -> name('filing');

    Route::get('/resume', 'IndexController@showResume') -> name('resume');
});

Route::group(['prefix' => env('APP_BACKEND_PREFIX'), 'namespace' => 'Backend', 'middleware' => 'auth'], function () {
    Route::get('/index', function () {
        return view('backend.index');
    }) -> name('adminIndex');

    Route::group(['prefix' => '/acl/actions'], function () {
        Route::get('/', 'ActionsController@showIndex') -> name('adminActions');
        Route::get('/add', 'ActionsController@showForm') -> name('adminAddActions');
        Route::get('/delete', 'ActionsController@delete') -> name('adminDeleteActions');
        Route::get('/edit', 'ActionsController@showForm') -> name('adminEditActions');
        Route::post('/store', 'ActionsController@store') -> name('adminStoreActions');
    });

    Route::group(['prefix' => '/acl/roles'], function () {
        Route::get('/', 'RolesController@showIndex') -> name('adminRoles');
        Route::get('/add', 'RolesController@showForm') -> name('adminAddRoles');
        Route::get('/delete', 'RolesController@delete') -> name('adminDeleteRoles');
        Route::get('/edit', 'RolesController@showForm') -> name('adminEditRoles');
        Route::post('/store', 'RolesController@store') -> name('adminStoreRoles');
    });

    Route::group(['prefix' => '/acl/users'], function () {
        Route::get('/', 'UsersController@showIndex') -> name('adminUsers');
        Route::get('/add', 'UsersController@showForm') -> name('adminAddUsers');
        Route::get('/delete', 'UsersController@delete') -> name('adminDeleteUsers');
        Route::get('/edit', 'UsersController@showForm') -> name('adminEditUsers');
        Route::post('/store', 'UsersController@store') -> name('adminStoreUsers');
    });

    Route::get('/notify', function () {
        return view('backend.notify');
    }) -> name('notify');

    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', 'SettingsController@showIndex') -> name('adminSettings');
        Route::get('/add', 'SettingsController@showForm') -> name('adminAddSetting');
        Route::post('/store', 'SettingsController@store') -> name('adminStoreSettings');
    });
});

Route::get('/notice', function () {
    return view('frontend.notice');
}) -> name('notice');

Route::group(['prefix' => 'sign', 'namespace' => 'Auth'], function () {
    Route::get('/in', 'LoginController@showLogin') -> name('login');
    Route::post('/in', 'LoginController@doUserLogin') -> name('doSignIn');
    Route::get('/out', 'LoginController@logout') -> name('doSignOut');
});
