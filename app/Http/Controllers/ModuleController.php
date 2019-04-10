<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Module;
use App\ModuleVersion;

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
     * @param  \Illuminate\Http\Request  $request href="{{ route('myModule',['id' => $module->id]) }}" target="_blank"
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request_module = $request->all();

      $image = $request->file('imgInp');
      $new_name = rand() . '.' . $image->getClientOriginalExtension();
      $image->move(public_path('images'), $new_name);
      $destination = 'images/';

      $modules = new Module;
      $modules->title = $request->input('mTitle');
      $modules->name = $request->input('mName');
      $modules->repository = $request->input('repository');
      $modules->category = $request->moduleCategory;
      $modules->logo = $destination.$new_name;
      $modules->screenshots = $destination.$new_name;
      $modules->description = $request->input('description');
      $modules->publisher_id = \Auth::user()->id;
      $modules->save();

      $module_versions = new ModuleVersion;
      $module_versions->commit = $request->input('mCommit');
      $module_versions->version = $request->input('mVersion');
      $module_versions->changelog = "First version";
      $module_versions->module_id = $modules->id;
      $module_versions->save();

      return redirect('/home');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $module = Module::find($id);
      $module_version = ModuleVersion::find($module->id);

      return view('modules-edit',compact(['module', 'module_version'], 'id'));
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $module = Module::find($id);
      $module_version = ModuleVersion::find($module->id);
      $module_version.$module->delete();

      return redirect('/home')->with('success','Information has been deleted');
        //
    }
}
