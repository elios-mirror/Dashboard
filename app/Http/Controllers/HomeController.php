<?php

namespace App\Http\Controllers;

use App\Module;
use App\ModuleVersion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modules = Module::paginate();

        $modules->getCollection()->transform(function ($value) {
            $modules_versions = ModuleVersion::get();
            $versions_array = array();
            $changes_array = array();

            foreach ($modules_versions as $module_version) {
                if ($value->id == $module_version->module_id) {
                    array_push($versions_array, $module_version->version);
                    array_push($changes_array, $module_version->changelog);
                }
            }
            $value->versions = $versions_array;
            $value->changes = $changes_array;

            return $value;
        });
      return view('home', ['modules' => $modules]);
    }
}
