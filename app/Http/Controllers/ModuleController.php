<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Module;
use App\ModuleVersion;
use App\ModuleScreenshots;

class ModuleController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $modules = Module::all();
    $module_versions = ModuleVersion::all();

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
        'applicationTitle' => 'required',
        'applicationName' => 'required',
        'repository' => 'required',
        'description' => 'required',
        'gitCommit' => 'required',
        'applicationVersion' => 'required',
    ]);

    $modules = new Module;
    $modules->title = $request->input('applicationTitle');
    $modules->name = $request->input('applicationName');
    $modules->repository = $request->input('repository');
    $modules->category = $request->moduleCategory;
    $modules->description = $request->input('description');
    $modules->publisher_id = \Auth::user()->id;

    if (!\File::isDirectory(public_path() . "images/" . \Auth::user()->id)) {
      \File::makeDirectory(public_path() . "images/" . \Auth::user()->id, 0755, true);
      \File::makeDirectory(public_path() . "images/" . \Auth::user()->id . "/Logo", 0755, true);
      \File::makeDirectory(public_path() . "images/" . \Auth::user()->id . "/Screenshots", 0755, true);
    }

    $logo = $request->file('logo');
    $logo_name = rand() . '.' . $logo->getClientOriginalExtension();
    $logo->move(public_path("images/" . \Auth::user()->id . "/Logo"), $logo_name);
    $logo_destination = "images/" . \Auth::user()->id . "/Logo/";

    $modules->logo_url = url(asset($logo_destination . $logo_name));
    $modules->save();

    if ($request->hasFile('screenshots')) {
      $screenshots = $request->file('screenshots');
      foreach ($screenshots as $screenshot) {

        $screen_name = rand() . '.' . $screenshot->getClientOriginalExtension();
        $screenshot->move(public_path("images/" . \Auth::user()->id . "/Screenshots"), $screen_name);
        $screen_destination = "images/" . \Auth::user()->id . "/Screenshots/";

        $module_screenshots = new ModuleScreenshots;
        $module_screenshots->screen_url = url(asset($screen_destination . $screen_name));
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
    $module = Module::find($id);
    $module_version = ModuleVersion::find($module->id);

    return view('modules-edit', compact(['module', 'module_version'], 'id'));
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
    $modules = Module::find($id);
    $module_version = ModuleVersion::find($id);

    $modules->name = $request->get('name');
    $modules->title = $request->get('title');
    $modules->description = $request->get('description');
    $modules->repository = $request->get('repository');
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
    $module = Module::find($id);
    $module_version = ModuleVersion::find($module->id);
    $module_version . $module->delete();

    return redirect('/home')->with('success', 'Information has been deleted');
    //
  }
}
