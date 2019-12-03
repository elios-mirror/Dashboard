<?php

namespace App\Http\Controllers;

use App\Module;
use App\ModuleScreenshots;
use App\ModuleVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ModuleUpdateController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @param Request $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $modules = Module::all();

    if ($request->wantsJSON()) {
      return response()->json($modules);
    }

    return view('module-update');
  }

  public function version($id)
  {
    $module = Module::findOrFail($id);
    $module_version = ModuleVersion::where('module_id', $id)->first();
    $module_screenshots = ModuleScreenshots::where('module_id', $id)->first();

    return view('modules-update', compact('module', 'module_version', 'module_screenshots', 'id'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('modules-update');
  }

  /**
   * Update the specified resource in storage.
   *
   * @param \Illuminate\Http\Request $request
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    request()->validate([
        'logo' => 'image',
        'changelog' => 'required|min:3|max:1000',
        'version' => 'required|min:3|max:20',
        'new_screenshots' => 'max:6',
        'new_screenshots.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        'form_configuration' => 'required|json',
        'form_configuration.*' => 'required|json',
        'form_configuration.*.type' => 'required|in:input,checkbox,dropdown',
        'form_configuration.*.name' => 'required|string',
        'form_configuration.*.placeholder' => 'required|string',
        'form_configuration.*.required' => 'boolean',
    ],
        ['new_screenshots.max' => 'The screenshots number may not be greater than 6 files.']
    );

    $module = Module::where('id', $id)->first();
    if ($request->has('logo')) {

      $update_logo = Storage::putFile('public/applications/images/' . Auth::user()->id . '/logos', $request->file('logo'));
      $module->logo_url = url(asset(Storage::url($update_logo)));
    }
    $module->form_configuration = $request->input("form_configuration");
    $module->save();

    $update_screenshots = $request->file('new_screenshots');

    if ($request->hasFile('new_screenshots')) {
      ModuleScreenshots::where('module_id', $id)->get()->each->delete();

      foreach ($update_screenshots as $update_screenshot) {
        $urlPath = Storage::putFile('public/applications/images/' . Auth::user()->id . '/screenshots', $update_screenshot);

        $new_screenshots = new ModuleScreenshots;
        $new_screenshots->screen_url = url(asset(Storage::url($urlPath)));
        $new_screenshots->module_id = $module->id;
        $new_screenshots->save();
      }
    }

    $module_versions = new ModuleVersion;
    $module_versions->version = $request->input('version');
    $module_versions->commit = $request->input('version');
    $module_versions->changelog = $request->input('changelog');
    $module_versions->module_id = $module->id;
    $module_versions->save();

    return redirect('/home');
  }
}
