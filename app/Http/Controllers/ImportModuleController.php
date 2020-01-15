<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImportModuleController extends Controller
{

  public function index(Request $request)
  {
    if ($request->has('json')
        && $request->has('name')
        && $request->has('version')) {
      $user = $request->user();
      $module = $user->publishedModules()->whereName($request->get('name'))->first();
      if ($module) {
        return redirect('/modules/updates/' . $module->id . '?json=' . urlencode($request->get('json')) .
            '&name=' . urlencode($request->get('name')) .
            '&version=' . urlencode($request->get('version')));
      }
    }
    return view('import-module');
  }
}
