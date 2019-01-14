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

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/myModule', 'MyModuleController@index')->name('myModule');
Route::get('/importModule', 'ImportModuleController@index')->name('importModule');
Route::get('/registered', function () {
    return view('registered');
});

Route::get('/email/resend', 'Auth\RegisterController@resend');
Route::get('/email/confirm/{token}', 'Auth\RegisterController@confirm');

Route::post('/importModule', 'ModuleController@store');
