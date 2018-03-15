<?php

namespace App\Http\Controllers;

use App\Mirror;
use Illuminate\Http\Request;

class MirrorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mirrors = Mirror::all();
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->wantsJson()) {
            $mirror = Mirror::create([
                'name' => $request->get('name'),
                'ip' => $request->getClientIp()
            ]);

            return (['status' => 'success', 'message' => 'Mirror created with success', 'id' => $mirror->id]);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mirror  $mirror
     * @return \Illuminate\Http\Response
     */
    public function show(Mirror $mirror)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mirror  $mirror
     * @return \Illuminate\Http\Response
     */
    public function edit(Mirror $mirror)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mirror  $mirror
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mirror $mirror)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mirror  $mirror
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mirror $mirror)
    {
        //
    }

    public function link(Mirror $mirror,  Request $request)
    {
        if ($request->wantsJson()) {
            $user = $request->user();
            $user->mirrors()->syncWithoutDetaching($mirror->id);
            return (['status' => 'success', 'message' => 'Mirror linked successfully', 'user_id' => $user->id, 'mirror_id' => $mirror->id]);
        }
    }
}
