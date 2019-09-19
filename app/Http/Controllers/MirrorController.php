<?php

namespace App\Http\Controllers;

use App\Mirror;
use App\Module;
use App\ModuleScreenshots;
use App\ModuleVersion;
use App\Notifications\MirrorInstalledModule;
use App\Notifications\MirrorLinked;
use App\Notifications\MirrorUninstalledModule;
use App\Notifications\MirrorUpdatedModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Notification;
use Ramsey\Uuid\Uuid;

class MirrorController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth:api')->except('store');
  }

  /**
   * Display a listing of the resource.
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $mirrors = $request->user()->mirrors()->get();
    return ($mirrors);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    if ($request->wantsJson()) {
      $mirror = Mirror::create([
          'name' => $request->get('name'),
          'model' => $request->has('model') ? $request->get('model') : 'LKD28376382',
          'ip' => $request->getClientIp(),
          'short_id' => uniqid()
      ]);

      $token = $mirror->createToken('My Token')->accessToken;

      return response()->json(['message' => 'Mirror created with success', 'id' => $mirror->id, 'short_id' => $mirror->short_id, 'model' => $mirror->model, 'access_token' => $token]);
    }
  }

  /**
   * Display the specified resource.
   *
   * @param Request $request
   * @param $id
   * @return \Illuminate\Http\Response
   */
  public function show(Request $request, $id)
  {
    $mirror = $request->user()->mirrors()->find($id);

    if (!$mirror) {
      return response()->json(['message' => 'Mirror not found for this user'], 404);
    }

    $mirror['modules'] = $mirror->link->modules()->with('module')->get();
    $screens = ModuleScreenshots::get();

    foreach ($mirror->modules as $module) {
      $screen_array = array();

      foreach ($screens as $screen) {
        if ($module->module->id == $screen->module_id) {
          array_push($screen_array, $screen->screen_url);
        }
      }

      $module->module->screenshots = $screen_array;
    }

    return response()->json($mirror);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param \App\Mirror $mirror
   * @return \Illuminate\Http\Response
   */
  public function edit(Mirror $mirror)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param \App\Mirror $mirror
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Mirror $mirror)
  {
    $form = $request->all();

    $mirror->update($form);
    $mirror->save();

    if ($request->wantsJson()) {
      return response()->json($mirror);
    } else {
      return back();
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param \App\Mirror $mirror
   * @return \Illuminate\Http\Response
   */
  public function destroy(Mirror $mirror)
  {
    //
  }

  public function link($mirrorID, Request $request)
  {
    $validator = Validator::make(['mirrorID' => $mirrorID], [
        'mirrorID' => 'required|string',
    ]);

    if ($validator->fails()) {
      return response()->json($validator->errors(), 422);
    }

    $mirror = Mirror::whereShortId($mirrorID)->first();
    if (!$mirror) {
      if (!Validator::make(['id' => $mirrorID], ['id' => 'uuid'])->fails()) {
        $mirror = Mirror::findOrFail($mirrorID);
      } else {
        abort(404, 'Cannot find mirror with id ' . $mirrorID);
      }
    }

    if (!$mirror) {
      return response()->json(['message' => 'Mirror not found'], 404);
    }

    if ($request->wantsJson()) {
      $user = $request->user();
      $linkId = Uuid::uuid4();
      $user->mirrors()->syncWithoutDetaching($mirror->id, ['link_id' => $linkId]);
      Notification::send($mirror, new MirrorLinked($mirror, $user, str_replace("Bearer ", "", $request->header("Authorization"))));
      return response()->json(['message' => 'Mirror linked successfully', 'user' => $user, 'mirror_id' => $mirror->id]);
    }
  }

  /**
   * @param $mirrorID
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function unlink($mirrorID, Request $request)
  {
    $validator = Validator::make(['mirrorID' => $mirrorID], [
        'mirrorID' => 'uuid',
    ]);

    if ($validator->fails()) {
      return response()->json(['message' => 'Mirror UUID invalid'], 422);
    }

    $user = $request->user();
    $mirror = $user->mirrors()->find($mirrorID);

    if (!$mirror) {
      return response()->json(['message' => 'Mirror not found'], 404);
    }

    $modules = $mirror->link->modules()->get();
    foreach ($modules as $module) {
      $mirror->link->modules()->detach($module->id);
    }
    $user->mirrors()->detach($mirror->id);
    if ($request->wantsJson()) {
      return response()->json(['message' => 'Mirror unlinked successfully', 'user_id' => $user->id, 'mirror_id' => $mirror->id]);
    }
  }

  /**
   * @param $mirrorId
   * @param $moduleId
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   * @throws \Exception
   */
  public function installModule($mirrorId, $moduleId, Request $request)
  {
    $mirror = $request->user()->mirrors()->find($mirrorId);

    if (!$mirror) {
      return response()->json(['message' => 'Mirror not found for this user'], 404);
    }

    $module = ModuleVersion::find($moduleId);
    if (!$module) {
      $module = Module::findOrFail($moduleId);
      $module = $module->lastVersion();
    }
    $installId = Uuid::uuid4();

    $mirror->link->modules()->attach($module->id, ['id' => $installId]);
    $mirror['modules'] = $mirror->link->modules()->with('module')->get();
    $module = $mirror->link->modules()->where('mirror_modules.id', $installId)->first();
    $module->module;
    Notification::send($mirror, new MirrorInstalledModule($mirror, $request->user(), $module));
    return response()->json($mirror);
  }

  /**
   * @param $mirrorId
   * @param $moduleId
   * @param Request $request
   * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
   */
  public function uninstallModule($mirrorId, $moduleId, Request $request)
  {
    $mirror = $request->user()->mirrors()->find($mirrorId);

    if (!$mirror) {
      return response()->json(['message' => 'Mirror not found for this user'], 404);
    }

    $module = ModuleVersion::find($moduleId);
    if (!$module) {
      $module = Module::find($moduleId);
      if (!$module) {
        return response(402);
      }
      foreach ($module->versions as $version) {
        $module = $mirror->link->modules()->where('mirror_modules.module_id', $version->id)->first();
        $mirror->link->modules()->detach($version->id);
      }
    } else {
      $module = $mirror->link->modules()->where('mirror_modules.module_id', $module->id)->first();
    }
    if (!$module) {
      return response()->json(['message' => 'Module not yet installed on this mirror'], 404);
    }
    $mirror->link->modules()->detach($module->id);
    $mirror['modules'] = $mirror->link->modules()->with('module')->get();
    $module->module;
    Notification::send($mirror, new MirrorUninstalledModule($mirror, $request->user(), $module));
    return response()->json($mirror);
  }

  /**
   * @param $mirrorId
   * @param $moduleId
   * @param Request $request
   * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
   */
  public function updateModule($mirrorId, $moduleId, Request $request)
  {
    $mirror = $request->user()->mirrors()->find($mirrorId);

    if (!$mirror) {
      return response()->json(['message' => 'Mirror not found for this user'], 404);
    }

    $module = ModuleVersion::find($moduleId);
    if (!$module) {
      $module = Module::find($moduleId);
      $newModuleVersion = $module->versions->last();
      if (!$module) {
        return response(402);
      }
      foreach ($module->versions as $version) {
        $module = $mirror->link->modules()->where('mirror_modules.module_id', $version->id)->first();
        $mirror->link->modules()->detach($version->id);
      }
    } else {
      $newModuleVersion = $module->module->versions->last();
      $module = $mirror->link->modules()->where('mirror_modules.module_id', $module->id)->first();
    }

    if (!$module) {
      return response()->json(['message' => 'Module not yet installed on this mirror'], 404);
    }


    $mirror->link->modules()->detach($module->id);
    $mirror->link->modules()->attach($newModuleVersion->id, ['id' => $module->link->id, 'settings' => $module->link->settings]);
    $mirror['modules'] = $mirror->link->modules()->with('module')->get();
    $newModuleVersion->module;
    Notification::send($mirror, new MirrorUpdatedModule($mirror, $request->user(), $newModuleVersion));
    return response()->json($mirror);
  }
}
