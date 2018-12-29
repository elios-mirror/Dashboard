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



Route::group(['middleware' => ['api', 'multiauth:mirror']], function () {
    Route::get('/mirror', function (Request $request) {
        return $request->user();
    });
});



Route::middleware(['auth:api'])->group(function () {

    Route::get('/user', function (Request $request) {
        $result = $request->user()->with('mirrors')->first();
        return $result;
    });

    Route::post('/mirrors/{mirror}/link', 'MirrorController@link');
    Route::post('/mirrors/{mirror}/unlink', 'MirrorController@unlink');

    Route::post('/mirrors/{mirror}/{module}', 'MirrorController@installModule');
    Route::delete('/mirrors/{mirror}/{module}', 'MirrorController@uninstallModule');

    Route::resource('modules', 'ModuleController');

});

Route::resource('mirrors', 'MirrorController');


Route::post('/password/email', 'Auth\ForgotPasswordController@getResetToken');
Route::post('/password/reset', 'Auth\ResetPasswordController@reset');
Route::post('/register', 'Auth\RegisterController@register');


