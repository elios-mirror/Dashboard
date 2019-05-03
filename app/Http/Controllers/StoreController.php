<?php

namespace App\Http\Controllers;

use App\Module;
use App\ModuleScreenshots;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index(Request $request)
    {
        $modules = Module::paginate();

        $modules->getCollection()->transform(function ($value) {
            $screens = ModuleScreenshots::get();
            $screen_array = array();

            foreach ($screens as $screen) {
                if ($value->id == $screen->module_id) {
                    array_push($screen_array, $screen->screen_url);
                }
            }
            $value->screenshots = $screen_array;

            return $value;
        });

        return $modules;
    }

    public function search(Request $request)
    {
        $search = $request->get('q');

        if (!$search) {
            abort(400, "Missing 'q' query param ");
        }
        $modules = Module::where('name', 'LIKE', '%' . $search . '%')
            ->orWhere('title', 'LIKE', '%' . $search . '%')
            ->paginate();

        $modules->getCollection()->transform(function ($value) {
            $screens = ModuleScreenshots::get();
            $screen_array = array();

            foreach ($screens as $screen) {
                if ($value->id == $screen->module_id) {
                    array_push($screen_array, $screen->screen_url);
                }
            }
            $value->screenshots = $screen_array;

            return $value;
        });
        return $modules;
    }
}
