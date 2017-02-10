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

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Activation Routes...
Route::post('account/activate/email', 'Auth\ActivateAccountController@sendActivationLink')->name('activation-email');
Route::get('account/activate', 'Auth\ActivateAccountController@activate')->name('activation');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password-reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

// Pre-defined routes
Route::resource('usuarios', 'UsersController', [
	'parameters' => [
	    'usuarios' => 'user'
	],
	'except' => ['create', 'edit']
]);

Route::resource('tipos-usuarios', 'UserTypesController', [
	'parameters' => [
	    'tipos-usuarios' => 'userType'
	],
	'except' => ['create', 'edit']
]);

Route::get('/home', 'HomeController@index');

Route::get('/', function () {
    return view('welcome');
});
