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
    Route::get('/users/{user_id}/modules', function (Request $request, $user_id) {
      $mirror = $request->user();
      $user = $mirror->users()->find($user_id);
      if (!$user) {
        return response()->json(['error' => 'No user found for this mirror'], 404);
      }
      $mirror = $user->link->modules()->with('module')->get();
      return $mirror;
    });
    Route::put('/users/{user_id}/modules/{install_id}', function (Request $request, $user_id, $install_id) {
      $mirror = $request->user();
      $user = $mirror->users()->find($user_id);
      if (!$user) {
        return response()->json(['error' => 'No user found for this mirror'], 404);
      }
      $module = $user->link->modules()->where('mirror_modules.id', $install_id)->first();
      $module->link->update($request->all());
      $module->save();
      $module->module;
      return $module;
    });
  });
});


Route::middleware(['auth:api'])->group(function () {

  Route::get('/user', function (Request $request) {
    $result = $request->user()->with('mirrors')->whereId($request->user()->id)->first();
    return $result;
  });

  Route::group(['prefix' => '/mirrors/{mirror_id}'], function () {
    Route::post('/link', 'MirrorController@link');
    Route::post('/unlink', 'MirrorController@unlink');

    Route::post('/{module}', 'MirrorController@installModule');
    Route::delete('/{module}', 'MirrorController@uninstallModule');
    Route::put('/{module}', 'MirrorController@updateModule');
    Route::put('/{module}/form', 'MirrorController@updateForm');
    Route::get('/{module}/form', 'MirrorController@getForm');

  });


  Route::resource('modules', 'ModuleController');
});


Route::resource('mirrors', 'MirrorController');

Route::post('/register', 'Auth\RegisterController@register');
Route::post('/password/email', 'Auth\ForgotPasswordController@getResetToken');


Route::group(['prefix' => 'store'], function () {
  Route::get('/', 'StoreController@index');
  Route::get('/search', 'StoreController@search');
});

Route::get('/', function () {
  $routeList = Route::getRoutes()->get();
  $routes = array();
  foreach ($routeList as $route) {
    $routes[str_replace("/", ".", $route->uri())] = $route->uri();
  }
  return $routes;
});

Route::get('/git/repo/check', 'StoreController@checkGitRepo');
Route::get('/git/repo/tags', 'StoreController@getGitTags');