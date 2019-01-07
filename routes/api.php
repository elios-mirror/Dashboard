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
    Route::group(['prefix' => 'mirror'], function () {
        Route::get('/', function (Request $request) {
            return $request->user()->with('users')->whereId($request->user()->id)->first();
        });
        Route::get('/users', function (Request $request) {
            $mirror = $request->user();
            $users = $mirror->users;
            return $users;
        });
        Route::get('/users/{userId}/modules', function (Request $request, $userId) {
            $mirror = $request->user();
            $user = $mirror->users()->find($userId);
            if (!$user) {
                return response()->json(['error' => 'No user found for this mirror'], 404);
            }
            $mirror = $user->link->modules()->with('module')->get();
            return $mirror;
        });
    });
});


Route::middleware(['auth:api'])->group(function () {

    Route::get('/user', function (Request $request) {
        $result = $request->user()->with('mirrors')->whereId($request->user()->id)->first();
        return $result;
    });

    Route::post('/mirrors/{mirror}/link', 'MirrorController@link');
    Route::post('/mirrors/{mirror}/unlink', 'MirrorController@unlink');

    Route::post('/mirrors/{mirror}/{module}', 'MirrorController@installModule');
    Route::delete('/mirrors/{mirror}/{module}', 'MirrorController@uninstallModule');

    Route::resource('modules', 'ModuleController');

});

Route::resource('mirrors', 'MirrorController');

Route::post('/register', 'Auth\RegisterController@register');


