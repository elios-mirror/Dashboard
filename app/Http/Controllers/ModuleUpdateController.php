<?php

namespace App\Http\Controllers;

use App\Module;
use App\ModuleScreenshots;
use App\ModuleVersion;
use Illuminate\Http\Request;

class ModuleUpdateController extends Controller
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

        return view('module-update', compact(['modules', 'module_versions']));
        //
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
        request()->validate([
            'changelog' => 'required|min:3|max:20',
        ]);

        $module_version = ModuleVersion::where('module_id', $id)->first();
        $module_version->changelog = $request->get('changelog');
        $module_version->save();

        return redirect('/home');
        //
    }
}
