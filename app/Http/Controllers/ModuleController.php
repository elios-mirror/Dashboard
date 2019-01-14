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
        return response()->json($modules);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request_module = $request->all();

      $modules = new Module;
      $modules->title = $request->input('mTitle');
      $modules->name = $request->input('mName');
      $modules->repository = $request->input('repository');
      $modules->description = $request->input('description');
      $modules->publisher_id = \Auth::user()->id;
      $modules->save();

      $module_versions = new ModuleVersion;
      $module_versions->commit = "d0b4f899a5ca55e7151d902077e6e4a7a2c4eb65";
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
        //
    }
}
