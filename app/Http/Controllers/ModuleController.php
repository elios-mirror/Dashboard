<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Module;
use App\ModuleVersion;
use App\ModuleScreenshots;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ModuleController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $modules = Module::all();
    $module_versions = ModuleVersion::where('module_id', $id)->first();

    if ($request->wantsJSON()) {
      return response()->json($modules);
    }

    return view('modules-index', compact(['modules', 'module_versions']));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    return view('modules-index');

    //
  }

  /**
   * Store a newly created resource in storage.
   * href="{{ route('myModule',['id' => $module->id]) }}" target="_blank"
   * @param \Illuminate\Http\Request $request href="{{ route('myModule',['id' => $module->id]) }}" target="_blank"
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    request()->validate([
        'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'applicationTitle' => 'required|min:3|max:20',
        'applicationName' => 'required|min:3|max:20',
        'repository' => 'required',
        'description' => 'required|min:40|max:1000',
        'gitCommit' => 'required',
        'applicationVersion' => 'required',
        'screenshots' => 'required|max: 6',
        'screenshots.*' => 'required|image|mimes:jpeg,png,jpg|max:2048'
    ]);

    $modules = new Module;
    $modules->title = $request->input('applicationTitle');
    $modules->name = $request->input('applicationName');
    $modules->repository = $request->input('repository');
    $modules->category = $request->moduleCategory;
    $modules->description = $request->input('description');
    $modules->publisher_id = Auth::user()->id;

    $logo = Storage::putFile('public/applications/images/' . Auth::user()->id . '/logos', $request->file('logo'));

    $modules->logo_url = url(asset(Storage::url($logo)));
    $modules->save();

    $screenshots = $request->file('screenshots');

    if ($request->hasFile('screenshots')) {
      foreach ($screenshots as $screenshot) {
        $urlPath = Storage::putFile('public/applications/images/' . Auth::user()->id . '/screenshots', $screenshot);

        $module_screenshots = new ModuleScreenshots;
        $module_screenshots->screen_url = url(asset(Storage::url($urlPath)));
        $module_screenshots->module_id = $modules->id;
        $module_screenshots->save();
      }
    }

    $module_versions = new ModuleVersion;
    $module_versions->commit = $request->input('gitCommit');
    $module_versions->version = $request->input('applicationVersion');
    $module_versions->changelog = "First version";
    $module_versions->module_id = $modules->id;
    $module_versions->save();

    return redirect('/home');
    //
  }

    /**
   * Display the specified resource.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $module = Module::findOrFail($id);
    $module->versions;
    return response()->json($module);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $module = Module::findOrFail($id);
    $module_version = ModuleVersion::where('module_id', $id)->first();

    return view('modules-edit', compact('module', 'module_version', 'id'));
    //
  }

    public function display($id)
  {
    $module = Module::findOrFail($id);
    $module_version = ModuleVersion::where('module_id', $id)->first();
    $module_screenshots = ModuleScreenshots::where('module_id', $id)->get();

    return view('module-display', compact('module', 'module_version', 'id', 'module_screenshots'));
    //
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
    $modules = Module::findOrFail($id);

    request()->validate([
        'title' => 'required|min:3|max:20',
        'name' => 'required|min:3|max:20',
        'description' => 'required|min:40|max:1000',
    ]);

    $modules->name = $request->get('name');
    $modules->title = $request->get('title');
    $modules->description = $request->get('description');
    $modules->save();

    return redirect('/home');
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param int $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $module = Module::findOrFail($id);
    $versions = ModuleVersion::where('module_id', $id)->get();
    foreach ($versions as $version) {
      DB::table('mirror_modules')->where('module_id', $version->id) ->delete();
    }
    ModuleScreenshots::where('module_id', $id)->get()->each->delete();
    ModuleVersion::where('module_id', $id)->get()->each->delete();

    $module->delete();
    return redirect('/home');
  }
}
