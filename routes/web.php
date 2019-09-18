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

Route::group(['middleware' => ['auth']], function () {
    Route::group(['prefix' => 'modules'], function () {
        Route::get('/', 'ModuleController@index')->name('index');

        Route::get('/import', 'ImportModuleController@index')->name('import');
        Route::post('/store', 'ModuleController@store')->name('store');

        Route::get('{id}/edit', 'ModuleController@edit')->name('edit');
        Route::patch('{id}/update', 'ModuleController@update');

        Route::delete('/{id}', 'ModuleController@destroy')->name('delete');

        Route::get('/{id}', 'ModuleController@display')->name('display');

        Route::group(['prefix' => 'updates'], function () {
            Route::get('{id}', 'ModuleUpdateController@version')->name('update');
            Route::patch('{id}/', 'ModuleUpdateController@update');
        });
    });
});

Route::get('/registered', function () {
    return view('registered');
});

Route::get('/email/resend', 'Auth\RegisterController@resend');
Route::get('/email/confirm/{token}', 'Auth\RegisterController@confirm');
