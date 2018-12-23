<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:api'])->group(function () {

    Route::get('/user', function (Request $request) {
        $result = $request->user()->with('mirrors')->get();
        return $result;
    });

    Route::post('/mirrors/{mirror}/link', 'MirrorController@link');
    Route::post('/mirrors/{mirror}/unlink', 'MirrorController@unlink');

    Route::resource('modules', 'ModuleController');

});

Route::resource('mirrors', 'MirrorController');


Route::post('/password/email', 'Auth\ForgotPasswordController@getResetToken');
Route::post('/password/reset', 'Auth\ResetPasswordController@reset');
Route::post('/register', 'Auth\RegisterController@register');


