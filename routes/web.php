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

Route::get('/import-module', 'ImportModuleController@index')->name('import-module');
Route::get('/import-module', 'ImportModuleController@repository')->name('import-module');
Route::post('/import-module', 'ModuleController@store');

Route::get('/modules-index', 'ModuleController@index')->name('modules-index');
Route::get('/modules-edit/{id}', 'ModuleController@edit');
Route::patch('/modules-edit/{id}', 'ModuleController@update');
Route::delete('/modules-index/{id}', 'ModuleController@destroy');

Route::get('/registered', function () {
    return view('registered');
});

Route::get('/email/resend', 'Auth\RegisterController@resend');
Route::get('/email/confirm/{token}', 'Auth\RegisterController@confirm');