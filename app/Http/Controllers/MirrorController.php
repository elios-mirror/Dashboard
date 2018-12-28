<?php

namespace App\Http\Controllers;

use App\Mirror;
use App\Module;
use App\ModuleVersion;
use App\Notifications\MirrorInstalledModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Notification;
use App\Notifications\MirrorLinked;

class MirrorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $mirrors = $request->user()->mirrors()->withCount('modules')->get();
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->wantsJson()) {
            $mirror = Mirror::create([
                'name' => $request->get('name'),
                'model' => $request->has('model') ? $request->get('model') : 'LKD28376382',
                'ip' => $request->getClientIp()
            ]);

            return response()->json(['message' => 'Mirror created with success', 'id' => $mirror->id, 'model' => $mirror->model]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mirror = Mirror::with('modules.module')->where('id', $id)->first();

        return response()->json($mirror);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mirror $mirror
     * @return \Illuminate\Http\Response
     */
    public function edit(Mirror $mirror)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Mirror $mirror
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
     * @param  \App\Mirror $mirror
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mirror $mirror)
    {
        //
    }

    public function link($mirrorID, Request $request)
    {
        $validator = Validator::make(['mirrorID' => $mirrorID], [
            'mirrorID' => 'uuid',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Mirror UUID invalid'], 422);
        }

        $mirror = Mirror::find($mirrorID);

        if (!$mirror) {
            return response()->json(['message' => 'Mirror not found'], 404);
        }

        if ($request->wantsJson()) {
            $user = $request->user();
            $user->mirrors()->syncWithoutDetaching($mirror->id);
            Notification::send($mirror, new MirrorLinked($mirror, $user, str_replace("Bearer ", "", $request->header("Authorization"))));
            return response()->json(['message' => 'Mirror linked successfully', 'user' => $user, 'mirror_id' => $mirror->id]);
        }
    }

    public function unlink($mirrorID, Request $request)
    {
        $validator = Validator::make(['mirrorID' => $mirrorID], [
            'mirrorID' => 'uuid',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Mirror UUID invalid'], 422);
        }

        $mirror = Mirror::find($mirrorID);

        if (!$mirror) {
            return response()->json(['message' => 'Mirror not found'], 404);
        }

        if ($request->wantsJson()) {
            $user = $request->user();
            $user->mirrors()->detach($mirror->id);
            return response()->json(['message' => 'Mirror unlinked successfully', 'user_id' => $user->id, 'mirror_id' => $mirror->id]);
        }
    }

    public function installModule($mirrorId, $moduleId, Request $request)
    {
        $mirror = Mirror::with('modules.module')->findOrFail($mirrorId);
        $module = ModuleVersion::find($moduleId);
        if (!$module) {
            $module = Module::find($moduleId);
            if (!$module) {
                return response(402);
            }
            $module = $module->lastVersion();
        }

        $mirror->modules()->syncWithoutDetaching($module->id);
        Notification::send($mirror, new MirrorInstalledModule($mirror, $request->user(), $module));
        return response()->json($mirror);
    }

    public function uninstallModule($mirrorId, $moduleId, Request $request)
    {
        $mirror = Mirror::with('modules.module')->findOrFail($mirrorId);
        $module = ModuleVersion::find($moduleId);
        if (!$module) {
            $module = Module::find($moduleId);
            if (!$module) {
                return response(402);
            }
            foreach ($module->versions as $version) {
                $mirror->modules()->detach($version->id);
            }
        } else {
            $mirror->modules()->detach($module->id);
        }
        return response()->json($mirror);
    }
}
