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
    
    Route::group(['prefix' => 'usergroup/{usergroup}'], function () {
        Route::get('user', 'Users\UserListController@index');
        Route::post('user/{id}/restore', 'Users\DeleteController@restoreTrashed');
        Route::post('user/{id}/harddelete', 'Users\DeleteController@hardDelete');
        Route::resource('user', 'Users\UserController', ['except' => ['index']]);
    });
        
    Route::group(['prefix' => 'settings'], function () {
        Route::resource('communities', 'Communities\CommunityController');
        Route::get('permissions/{role}', 'Roles\PermissionController@index');
        Route::post('permissions/{role}', 'Roles\PermissionController@save');
    });
    Route::get('/home', 'Users\HomeController@index');
});
