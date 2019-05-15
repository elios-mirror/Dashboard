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

Route::group(['prefix' => 'modules'], function() {
    Route::get('/', 'ModuleController@index')->name('modules-index');

    Route::get('/import', 'ImportModuleController@index')->name('import-module');
    Route::post('/import', 'ModuleController@store')->name('import-module');

    Route::get('/edit/{id}', 'ModuleController@edit')->name('modules-edit');
    Route::patch('/{id}', 'ModuleController@update');
    Route::delete('/{id}', 'ModuleController@destroy');

    Route::get('/{id}', 'ModuleController@display')->name('modules-display');
});


Route::get('/registered', function () {
    return view('registered');
});

Route::get('/email/resend', 'Auth\RegisterController@resend');
Route::get('/email/confirm/{token}', 'Auth\RegisterController@confirm');
