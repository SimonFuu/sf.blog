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
    Route::get('/archive/{sid}', 'ArchivesController@showArchive') -> name('archive');
    Route::post('/archive/statistics', 'ArchivesController@statistic') -> name('archiveStatisticUrl');

    Route::get('/blog', 'CategoryController@showCategoryArchives') -> name('blog');

    Route::get('/category/{name}', 'CategoryController@showCategoryArchives') -> name('category');

    Route::get('/daily', 'IndexController@showAllDaily') -> name('daily');

    Route::get('/filing/{month}', 'FilingController@showFilingArchives') -> name('filing');

    Route::get('/resume', 'IndexController@showResume') -> name('resume');

    Route::group(['prefix' => 'tail'], function () {
        Route::get('/towns', 'TailController@showTowns') -> name('tailTowns');
    });
});

Route::group(['prefix' => config('app.backend_prefix'), 'namespace' => 'Backend', 'middleware' => 'auth'], function () {
    Route::get('/', 'BackendController@redirectIndex');

    Route::get('/index', 'BackendController@showDashboard') -> name('adminIndex');

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

    Route::group(['prefix' => '/archives'], function() {
        Route::get('/', 'ArchivesController@showIndex') -> name('adminArchives');
        Route::get('/add', 'ArchivesController@showForm') -> name('adminAddArchive');
        Route::get('/edit', 'ArchivesController@showForm') -> name('adminEditArchive');
        Route::get('/delete', 'ArchivesController@delete') -> name('adminDeleteArchive');
        Route::post('/store', 'ArchivesController@store') -> name('adminStoreArchive');
    });

    Route::group(['prefix' => '/catalogs'], function() {
        Route::get('/', 'CatalogsController@showIndex') -> name('adminCatalogs');
        Route::get('/add', 'CatalogsController@showForm') -> name('adminAddCatalog');
        Route::get('/edit', 'CatalogsController@showForm') -> name('adminEditCatalog');
        Route::get('/delete', 'CatalogsController@delete') -> name('adminDeleteCatalog');
        Route::post('/store', 'CatalogsController@store') -> name('adminStoreCatalog');
    });

    Route::group(['prefix' => '/categories'], function() {
        Route::get('/', 'CategoriesController@showIndex') -> name('adminCategories');
        Route::get('/add', 'CategoriesController@showForm') -> name('adminAddCategory');
        Route::get('/edit', 'CategoriesController@showForm') -> name('adminEditCategory');
        Route::get('/delete', 'CategoriesController@delete') -> name('adminDeleteCategory');
        Route::post('/store', 'CategoriesController@store') -> name('adminStoreCategory');
    });

    Route::get('/notify', 'BackendController@showNotification') -> name('notify');

    Route::group(['prefix' => 'settings'], function () {
        Route::get('/', 'SettingsController@showIndex') -> name('adminSettings');
        Route::get('/add', 'SettingsController@showForm') -> name('adminAddSetting');
        Route::get('/edit', 'SettingsController@showForm') -> name('adminEditSetting');
        Route::post('/store', 'SettingsController@store') -> name('adminStoreSetting');
    });

    Route::group(['prefix' => 'upload'], function () {
        Route::post('/new', 'UploaderController@store') -> name('adminUploadFile');
        Route::post('/delete', 'UploaderController@delete') -> name('adminDeleteUploadFile');
    });
});

Route::get('/notice', 'Controller@showNotice') -> name('notice');

Route::group(['prefix' => 'sign', 'namespace' => 'Auth'], function () {
    Route::get('/in', 'LoginController@showLogin') -> name('login');
    Route::post('/in', 'LoginController@doUserLogin') -> name('doSignIn');
    Route::get('/out', 'LoginController@logout') -> name('doSignOut');
});
