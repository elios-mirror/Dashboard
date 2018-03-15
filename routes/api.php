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
        $result = $request->user();
        $result['mirrors'] = $request->user()->mirrors()->get();
        return $result;
    });

    Route::resource('mirrors', 'MirrorController');

    Route::post('/mirrors/{mirror}/link', 'MirrorController@link');

});

