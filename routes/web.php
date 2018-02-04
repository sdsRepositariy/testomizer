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

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes deleted

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

/*
|--------------------------------------------------------------------------
| Admin and Users Routes
|--------------------------------------------------------------------------
*/

//
Route::group(['middleware'=>'auth'], function () {
    Route::group(['prefix' => 'usergroup/students'], function () {
        Route::get('list', 'Users\Students\UserListController@getList');
        Route::post('user/{user}/restore', 'Users\Students\DeleteController@restoreTrashed');
        Route::post('user/{user}/harddelete', 'Users\Students\DeleteController@hardDelete');
        Route::get('user/{user}/changepassword', 'Users\Students\UserController@changePassword');
        Route::resource('user', 'Users\Students\UserController', ['except' => ['index']]);
        Route::get('upload', 'Users\Students\UploadUserListController@upload');
        Route::post('upload', 'Users\Students\UploadUserListController@store');
        Route::get('download', 'Users\Students\DownloadUserListController@download');
    });

    Route::group(['prefix' => 'usergroup/parents'], function () {
        Route::get('list', 'Users\Parents\UserListController@getList');
        Route::get('user/{user}/changepassword', 'Users\Parents\UserController@changePassword');
        Route::get('user/{user}', 'Users\Parents\UserController@show');
        Route::get('user/{user}/edit', 'Users\Parents\UserController@edit');
        Route::get('user/create/student/{user}', 'Users\Parents\UserController@create');
        Route::post('user', 'Users\Parents\UserController@store');
        Route::put('user/{user}', 'Users\Parents\UserController@update');
        Route::get('download', 'Users\Parents\DownloadUserListController@download');
    });

    Route::group(['prefix' => 'usergroup/teachers'], function () {
        Route::get('list', 'Users\Teachers\UserListController@getList');
        Route::get('user/{user}/changepassword', 'Users\Teachers\UserController@changePassword');
        Route::post('user/{user}/restore', 'Users\Teachers\DeleteController@restoreTrashed');
        Route::post('user/{user}/harddelete', 'Users\Teachers\DeleteController@hardDelete');
        Route::resource('user', 'Users\Teachers\UserController', ['except' => ['index']]);
        Route::get('upload', 'Users\Teachers\UploadUserListController@upload');
        Route::post('upload', 'Users\Teachers\UploadUserListController@store');
    });
        
    Route::group(['prefix' => 'settings'], function () {
        Route::get('communities/getregions', 'Communities\CommunityController@getRegions');
        Route::get('communities/getcities', 'Communities\CommunityController@getCities');
        Route::get('communities/gettypes', 'Communities\CommunityController@gettypes');
        Route::resource('communities', 'Communities\CommunityController');
        Route::get('permissions/{role}', 'Roles\PermissionController@index');
        Route::post('permissions/{role}', 'Roles\PermissionController@save');
    });
    Route::get('/home', 'Users\HomeController@index');
});
